<?php

// ! Q1  ! //
class Circle
{
    private float $radius;
    private string $color;

    function __construct(float $radius = 1.0, string $color = "red"){
        $this->radius = $radius;
        $this->color = $color;
    }

    public function getRadius(){
        return $this->radius;
    }

    public function setRadius(float $radius){
        $this->radius = $radius;
    }

    public function getColor(){
        return $this->color;
    }

    public function setColor(string $color){
        $this->color = $color;
    }

    public function getArea(){
        return pi() * $this->radius * $this->radius;
    }

    public function __toString(){
        return "Circle[radius={$this->radius},color={$this->color}]";
    }
}

// ! Q2 ! //
class Employee
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $salary;

    public function __construct(int $id, string $firstName, string $lastName, int $salary){
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary = $salary;
    }

    public function getId(){
        return $this->id;
    }

    public function getFirstName(){
        return $this->firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function getName(){
        return "{$this->firstName} {$this->lastName}";
    }

    public function getSalary(){
        return $this->salary;
    }
    public function getAnnualSalary(){
        return $this->salary * 12;
    }

    public function setSalary(int $salary){
        $this->salary = $salary;
    }
    public function raiseSalary(int $percent){
        $this->salary += (int) round($this->salary * ($percent / 100));
        return $this->salary;
    }

    public function __toString(){
        return "Employee[id={$this->id},name={$this->getName()},salary={$this->salary}]";
    }
}


class Rectangle
{
    private float $length;
    private float $width;

    public function __construct(float $length = 1.0, float $width = 1.0){
        $this->length = $length;
        $this->width = $width;
    }

    public function getLength(){
        return $this->length;
    }
    public function setLength(float $length){
        $this->length = $length;
    }

    public function getWidth(){
        return $this->width;
    }
    public function setWidth(float $width){
        $this->width = $width;
    }

    public function getArea(){
        return $this->length * $this->width;
    }

    public function getPerimeter(){
        return 2 * ($this->length + $this->width);
    }

    public function __toString(){
        return "Rectangle[length={$this->length},width={$this->width}]";
    }
}


class InvoiceItem
{
    private string $id;
    private string $desc;
    private int $qty;
    private float $unitPrice;

    public function __construct(string $id, string $desc, int $qty, float $unitPrice){
        $this->id = $id;
        $this->desc = $desc;
        $this->qty = $qty;
        $this->unitPrice = $unitPrice;
    }

    public function getId(){
        return $this->id;
    }

    public function getDesc(){
        return $this->desc;
    }

    public function getQty(){
        return $this->qty;
    }

    public function setQty(int $qty){
        $this->qty = $qty;
    }

    public function getUnitPrice(){
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice){
        $this->unitPrice = $unitPrice;
    }

    public function getTotal(){
        return $this->unitPrice * $this->qty;
    }

    public function __toString(){
        return "InvoiceItem[id={$this->id},desc={$this->desc},qty={$this->qty},unitPrice={$this->unitPrice}]";
    }
}