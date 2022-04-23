<?php

namespace App\Services\Payment;

/**
 * @description : Invoice Class make an object of necessary information for payment such as (Amount , user id , description , order id and etc..)
 */
class Invoice
{

    /**
     * @var int
     */
    protected $amount;
    protected $user_id;
    protected $user_email;
    protected $user_phone;
    protected $description;
    protected $authority;

    public function setAmount(int $amount): int
    {
        return $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * @param mixed $user_email
     */
    public function setUserEmail($user_email): void
    {
        $this->user_email = $user_email;
    }

    /**
     * @return mixed
     */
    public function getUserPhone()
    {
        return $this->user_phone;
    }

    /**
     * @param mixed $user_phone
     */
    public function setUserPhone($user_phone): void
    {
        $this->user_phone = $user_phone;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function setAuthority($authority)
    {
        $this->authority = $authority;
    }

    public function getAuthority()
    {
        return $this->authority;
    }
}
