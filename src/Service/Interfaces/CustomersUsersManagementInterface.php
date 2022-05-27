<?php
namespace App\Service\Interfaces;

use App\Entity\Customers;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;

interface CustomersUsersManagementInterface
{
    public function customersUsersList(Customers $customer, int $page): string;

    public function customerUserShow(Request $request): string;

    public function addUserLinkedCustomer(Request $request);

    public function deleteUserLinkedCustomer(Request $request): string;
}
