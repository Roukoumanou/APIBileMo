<?php
namespace App\Service\Traitements;

use App\Entity\Users;
use App\Entity\Customers;
use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Route;
use App\Repository\UsersRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\CustomersRepository;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Exceptions\ResourceViolationException;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use App\Service\Interfaces\CustomersUsersManagementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class CustomersUsersService implements CustomersUsersManagementInterface
{
    public const MAX_PER_PAGE = 5;

    private UsersRepository $usersRepository;

    private EntityManagerInterface $em;

    private CustomersRepository $customersRepository;

    private ValidatorInterface $validator;

    private UserPasswordHasherInterface $hasher;

    private SerializerInterface $serializer;

    private SerializerSerializerInterface $symSerializer;

    public function __construct(
        UsersRepository $usersRepository,
        EntityManagerInterface $em,
        CustomersRepository $customersRepository,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $hasher,
        SerializerInterface $serializer, 
        SerializerSerializerInterface $symSerializer
    )
    {
        $this->usersRepository = $usersRepository;
        $this->em = $em;
        $this->customersRepository = $customersRepository;
        $this->validator = $validator;
        $this->hasher = $hasher;
        $this->serializer = $serializer;
        $this->symSerializer = $symSerializer;
    }

    /**
     * Le service qui gère la liste des utilisateurs liés à un client
     *
     * @param Customers $customer
     * @return array
     */
    public function customersUsersList(Customers $customer, int $page = 1): string
    {
        $users = $this->usersRepository->findByCustomer($customer);

        $adapter = new ArrayAdapter($users);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, self::MAX_PER_PAGE);
        $currentPageResults = $pagerfanta->getCurrentPageResults();

        $pagerfantaFactory   = new PagerfantaFactory(); // you can pass the page and limit parameters name
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pagerfanta,
            new Route('customer_users', ['id' => $customer->getId()]),
            new CollectionRepresentation($currentPageResults)
        );

        $data = $this->serializer->serialize($paginatedCollection, 'json');

        return (string) $data;
    }

    /**
     * Renvois un utilisateur lié à un client pour affichage de ses détails
     *
     * @param Request $request
     * @return string
     */
    public function customerUserShow(Request $request): string
    {
        $id = (int) $request->get('id');
        $email = (string) $request->get('email');

        $customer = $this->getCustomer($id);


        $user = $this->getUser($customer, $email);

        $data = $this->serializer->serialize($user, 'json');

        return (string) $data;
    }

    /**
     * Ajoute un utilisateur lié à un client dans la base de donnée
     *
     * @param Request $request
     */
    public function addUserLinkedCustomer(Request $request)
    {
        $id = (int) $request->get('id');

        $customer = $this->getCustomer($id);
        
        /** @var Users $user */
        $user = $this->symSerializer->deserialize( (string) $request->getContent(), "App\Entity\Users", 'json');

        $errors = $this->validator->validate($user);
        
        $messages = "";
        if (count($errors)) {
            
            foreach ($errors as $error) {
                $messages .= sprintf(
                    "Field %s: %s ",
                    $error->getPropertyPath(),
                    $error->getMessage()
                );
            }

            throw new ResourceViolationException($messages);
        }

        $password = $this->hasher->hashPassword($user, $user->getPassword());


        $user->setCreatedAt(new \DateTimeImmutable())
            ->setPassword($password)
            ->setCustomer($customer);
            
        $this->em->persist($user);
        $this->em->flush();

        $data = $this->serializer->serialize($user, 'json');

        return $data;
    }

    /**
     * Permet de désactiver un utilisateur lié à un client dans la base de donnée
     *
     * @param Request $request
     * @return Users
     */
    public function deleteUserLinkedCustomer(Request $request): string
    {
        $id = (int) $request->get('id');
        $email = (string) $request->get('email');

        $customer = $this->getCustomer($id);
        $user = $this->getUser($customer, $email);
        $user->setIsValid(false);

        $this->em->flush();

        $data = $this->serializer->serialize($user, 'json');

        return $data;
    }

    /**
     * Renvois un client ou null
     *
     * @param int $id
     * @return Customers|null
     */
    private function getCustomer(string $id): ?Customers
    {
        $customer = $this->customersRepository->find($id);

        return $customer;
    }

    /**
     * Renvois null ou un utilisateur
     *
     * @param Customers $customer
     * @param string $email
     * @return Users|null
     */
    private function getUser(Customers $customer, string $email): ?Users
    {
        
        /** @var Users $user */
        $user = $this->usersRepository->findFordetail($email, $customer);

        return $user;
    }
}
