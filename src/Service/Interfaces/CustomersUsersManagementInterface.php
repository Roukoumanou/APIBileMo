<?php
namespace App\Service\Interfaces;

use App\Entity\Customers;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface CustomersUsersManagementInterface
{
    public function customersUsersList(Customers $customer, int $page): string;

    public function customerUserShow(Customers $customer, Request $request): string;

    public function addUserLinkedCustomer(Customers $customer, Request $request);

    public function deleteUserLinkedCustomer(Customers $customer, Request $request): string;
}
