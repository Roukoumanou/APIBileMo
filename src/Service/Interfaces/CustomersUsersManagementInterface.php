<?php
namespace App\Service\Interfaces;

use App\Entity\Customers;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface CustomersUsersManagementInterface
{
    public function customersUsersList(Customers $customer): array;

    public function customerUserShow(Request $request): ?Users;

    public function addUserLinkedCustomer(Request $request): Users;

    public function DeleteUserLinkedCustomer(Request $request): Users;
}
