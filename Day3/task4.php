<?php

abstract class Person
{
    private string $name;
    private string $address;

    public function __construct(string $name, string $address){
        $this->name = $name;
        $this->address = $address;
    }

    public function getName(){
        return $this->name;
    }

    public function getAddress(){
        return $this->address;
    }
    public function setAddress(string $address){
        $this->address = $address;
    }

    abstract public function __toString(): string;
}


class Student extends Person
{
    private string $program;
    private int $year;
    private float $fee;

    public function __construct(string $name, string $address, string $program, int $year, float $fee){
        parent::__construct($name, $address);
        $this->program = $program;
        $this->year = $year;
        $this->fee = $fee;
    }

    public function getProgram(){
        return $this->program;
    }
    public function setProgram(string $program){
        $this->program = $program;
    }

    public function getYear(){
        return $this->year;
    }
    public function setYear(int $year){
        $this->year = $year;
    }

    public function getFee(){
        return $this->fee;
    }
    public function setFee(float $fee){
        $this->fee = $fee;
    }

    #[\Override]
    public function __toString(){
        return "Student[Person[name={$this->getName()},address={$this->getAddress()}],program={$this->program},year={$this->year},fee={$this->fee}]";
    }
}


class Staff extends Person
{
    private string $school;
    private float $pay;

    public function __construct(string $name, string $address, string $school, float $pay){
        parent::__construct($name, $address);
        $this->school = $school;
        $this->pay = $pay;
    }

    public function getSchool(){
        return $this->school;
    }
    public function setSchool(string $school){
        $this->school = $school;
    }

    public function getPay(){
        return $this->pay;
    }
    public function setPay(float $pay){
        $this->pay = $pay;
    }

    #[\Override]
    public function __toString(){
        return "Staff[Person[name={$this->getName()},address={$this->getAddress()}],school={$this->school},pay={$this->pay}]";
    }
}


abstract class Shape
{
    protected string $color;
    protected bool $filled;

    public function __construct(string $color = "red", bool $filled = true){
        $this->color = $color;
        $this->filled = $filled;
    }

    public function getColor(){
        return $this->color;
    }
    public function setColor(string $color){
        $this->color = $color;
    }

    public function isFilled(){
        return $this->filled;
    }
    public function setFilled(bool $filled){
        $this->filled = $filled;
    }

    abstract public function getArea();
    abstract public function getPerimeter();

    public function __toString(){
        $filledStr = $this->filled ? "true" : "false";
        return "Shape[color={$this->color},filled={$filledStr}]";
    }
}


class CircleShape extends Shape
{
    protected float $radius;

    public function __construct(float $radius = 1.0, string $color = "red", bool $filled = true){
        parent::__construct($color, $filled);
        $this->radius = $radius;
    }

    public function getRadius(){
        return $this->radius;
    }

    public function setRadius(float $radius){
        $this->radius = $radius;
    }

    #[\Override]
    public function getArea(){
        return pi() * $this->radius * $this->radius;
    }

    #[\Override]
    public function getPerimeter(){
        return 2 * pi() * $this->radius;
    }

    #[\Override]
    public function __toString(){
        return "Circle[" . parent::__toString() . ",radius={$this->radius}]";
    }
}


class RectangleShape extends Shape
{
    protected float $width;
    protected float $length;

    public function __construct(float $width = 1.0, float $length = 1.0, string $color = "red", bool $filled = true){
        parent::__construct($color, $filled);
        $this->width = $width;
        $this->length = $length;
    }

    public function getWidth(){
        return $this->width;
    }
    public function setWidth(float $width){
        $this->width = $width;
    }

    public function getLength(){
        return $this->length;
    }
    public function setLength(float $length){
        $this->length = $length;
    }

    #[\Override]
    public function getArea(){
        return $this->width * $this->length;
    }

    #[\Override]
    public function getPerimeter(){
        return 2 * ($this->width + $this->length);
    }

    #[\Override]
    public function __toString(){
        return "Rectangle[" . parent::__toString() . ",width={$this->width},length={$this->length}]";
    }
}


class Square extends RectangleShape
{
    public function __construct(float $side = 1.0, string $color = "red", bool $filled = true){
        parent::__construct($side, $side, $color, $filled);
    }

    public function getSide(){
        return $this->getWidth();
    }
    public function setSide(float $side){
        $this->width = $side;
        $this->length = $side;
    }

    #[\Override]
    public function setWidth(float $side){
        $this->setSide($side);
    }

    #[\Override]
    public function setLength(float $side){
        $this->setSide($side);
    }

    #[\Override]
    public function __toString(){
        return "Square[" . parent::__toString() . "]";
    }
}
~
>