<?php

declare(strict_types=1);


namespace Lichi\Iiko\Sdk\IIKOCard\Authorization;


class CustomerForImport
{
    private string $name;
    private string $phone;
    private string $magnetCardTrack;
    private string $birthday;

    public function __construct(array $config)
    {
        $this->name = $config['name'];
        $this->phone = $config['phone'];
        $this->magnetCardTrack = $config['phone'];
        $this->birthday = $config['birthday'];
    }

    public function getCustomer(){
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'magnetCardTrack' => $this->magnetCardTrack,
            'birthday' => $this->birthday
        ];
    }

}