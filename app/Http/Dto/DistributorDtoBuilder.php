<?php

namespace App\Http\Dto;

use App\Models\User;
use App\Utils\Enum\Leg;
use App\Utils\Trait\DataSanitizer;

class DistributorDtoBuilder
{
    use DataSanitizer;

    public string $name;
    public string $username;
    public string $uplineId;
    public Leg $leg;
    public string $phone;
    public string $country;

    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function setName(string $name): self
    {
        $this->name = $this->sanitize($name);
        return $this;
    }

    public function setUsername(string $username): self
    {
        $existingUser = User::where('username', $username)->first();

        if ($existingUser) {
            throw new \Exception('Username already exist');
        }

        $this->username = $this->sanitize($username);
        return $this;
    }

    public function setUplineId(string $uplineId): self
    {
        $this->uplineId = $this->sanitize($uplineId);
        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $this->sanitize($phone);
        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $this->sanitize($country);
        return $this;
    }

    public function setSelectedLeg(string $leg): self
    {
        $lowercaseLeg = strtolower($leg);

        if (!in_array($lowercaseLeg, ["left", "right"])) {
            throw new \Exception("Invalid leg provided");
        }

        $this->leg = match ($lowercaseLeg) {
            "left" => Leg::LEFT,
            "right" => Leg::RIGHT
        };

        return $this;
    }
}
