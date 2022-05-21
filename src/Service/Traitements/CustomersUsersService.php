<?php
namespace App\Service\Traitements;

use App\Entity\Users;
use App\Entity\Customers;
use App\Repository\UsersRepository;
use App\Repository\CustomersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Interfaces\CustomersUsersManagementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomersUsersService implements CustomersUsersManagementInterface
{
    private UsersRepository $usersRepository;

    private EntityManagerInterface $em;

    private CustomersRepository $customersRepository;

    private ValidatorInterface $validator;

    private UserPasswordHasherInterface $hasher;

    private SerializerInterface $serializer;

    public function __construct(
        UsersRepository $usersRepository,
        EntityManagerInterface $em,
        CustomersRepository $customersRepository,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $hasher,
        SerializerInterface $serializer
    )
    {
        $this->usersRepository = $usersRepository;
        $this->em = $em;
        $this->customersRepository = $customersRepository;
        $this->validator = $validator;
        $this->hasher = $hasher;
        $this->serializer = $serializer;
    }

    /**
     * Le service qui gère la liste des utilisateurs liés à un client
     *
     * @param Customers $customer
     * @return array
     */
    public function customersUsersList(Customers $customer): array
    {
        $users = $this->usersRepository->findByCustomer($customer);

        $customerDetail = [
            'N° de Client' => $customer->getId(), 
            'Comagnie du client' => $customer->getCompany(),
            'Liste des utilisateurs liés a ce client' => '..............',

        ];

        $data = array_merge($customerDetail, $users);

        return $data;
    }

    /**
     * Renvois un utilisateur lié à un client pour affichage de ses détails
     *
     * @param Request $request
     * @return Users|null
     */
    public function customerUserShow(Request $request): ?Users
    {
        $id = (int) $request->get('id');
        $email = (string) $request->get('email');

        $customer = $this->getCustomer($id);


        $user = $this->getUser($customer, $email);

        return $user;
    }

    /**
     * Ajoute un utilisateur lié à un client dans la base de donnée
     *
     * @param Request $request
     * @return Users
     */
    public function addUserLinkedCustomer(Request $request): Users
    {
        $id = (int) $request->get('id');

        $customer = $this->getCustomer($id);

        /** @var Users $user */
        $user = $this->serializer->deserialize($request->getContent(), Users::class, 'json');

        $password = $this->hasher->hashPassword($user, $user->getPassword());

        $errors = $this->validator->validate($user);
        
        if (count($errors)) {
            return $this->serializer->serialize($errors, 'json');
        }

        $user->setCreatedAt(new \DateTimeImmutable())
            ->setPassword($password)
            ->setCustomer($customer);
            
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Permet de désactiver un utilisateur lié à un client dans la base de donnée
     *
     * @param Request $request
     * @return Users
     */
    public function DeleteUserLinkedCustomer(Request $request): Users
    {
        $id = (int) $request->get('id');
        $email = (string) $request->get('email');

        $customer = $this->getCustomer($id);
        $user = $this->getUser($customer, $email);
        $user->setIsValid(false);

        $this->em->flush();

        return $user;
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
