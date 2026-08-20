<?php

class Author
{
    private string $name;
    private string $email;
    private string $gender;

    public function __construct(string $name, string $email, string $gender){
        $this->name = $name;
        $this->email = $email;
        $this->gender = $gender;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getGender(){
        return $this->gender;
    }

    public function __toString(){
        return "Author[name={$this->name},email={$this->email},gender={$this->gender}]";
    }
}


class Book
{
    private string $name;
    private Author $author;
    private float $price;
    private int $qty;

    public function __construct(string $name, Author $author, float $price, int $qty = 0){
        $this->name = $name;
        $this->author = $author;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function getName(){
        return $this->name;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function getPrice(){
        return $this->price;
    }
    public function setPrice(float $price){
        $this->price = $price;
    }

    public function getQty(){
        return $this->qty;
    }
    public function setQty(int $qty){
        $this->qty = $qty;
    }

    public function __toString(){
        return "Book[name={$this->name},{$this->author},price={$this->price},qty={$this->qty}]";
    }
}


class MultiAuthorBook
{
    private string $name;
    /** @var Author[] */
    private array $authors;
    private float $price;
    private int $qty;

    public function __construct(string $name, array $authors, float $price, int $qty = 0){
        $this->name = $name;
        $this->authors = $authors;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function getName(){
        return $this->name;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(){
        return $this->authors;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice(float $price){
        $this->price = $price;
    }

    public function getQty(){
        return $this->qty;
    }

    public function setQty(int $qty){
        $this->qty = $qty;
    }

    public function getAuthorNames(){
        $names = array_map(fn($author) => $author->getName(), $this->authors);
        return implode(", ", $names);
    }

    public function __toString(){
        $authorsStr = implode(",", array_map(fn($author) => (string)$author, $this->authors));
        return "Book[name={$this->name},authors={{$authorsStr}},price={$this->price},qty={$this->qty}]";
    }
}


class SessionAuthor
{
    private string $name;
    private string $email;

    public function __construct(string $name, string $email){
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }

    public function __toString(){
        return "Author[name={$this->name},email={$this->email}]";
    }
}


class IsbnBook
{
    private string $isbn;
    private string $name;
    private SessionAuthor $author;
    private float $price;
    private int $qty;

    public function __construct(string $isbn, string $name, SessionAuthor $author, float $price, int $qty = 0){
        $this->isbn = $isbn;
        $this->name = $name;
        $this->author = $author;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function getIsbn(){
        return $this->isbn;
    }

    public function getName(){
        return $this->name;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function getPrice(){
        return $this->price;
    }
    public function setPrice(float $price){
        $this->price = $price;
    }

    public function getQty(){
        return $this->qty;
    }
    public function setQty(int $qty){
        $this->qty = $qty;
    }

    public function getAuthorName(){
        return $this->author->getName();
    }

    public function __toString(){
        return "Book[isbn={$this->isbn},name={$this->name},{$this->author},price={$this->price},qty={$this->qty}]";
    }
}


trait CircleTrait
{
    private float $radius = 1.0;
    private string $color = "red";

    public function getRadius(): float
    {
        return $this->radius;
    }

    public function setRadius(float $radius): void
    {
        $this->radius = $radius;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getArea(): float
    {
        return pi() * $this->radius * $this->radius;
    }

    public function circleToString(): string
    {
        return "Circle[radius={$this->radius},color={$this->color}]";
    }
}


class Cylinder
{
    use CircleTrait;

    private float $height = 1.0;

    public function __construct(float $radius = 1.0, float $height = 1.0, string $color = "red")
    {
        $this->setRadius($radius);
        $this->height = $height;
        $this->setColor($color);
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    public function getVolume(): float
    {
        return $this->getArea() * $this->height;
    }

    public function __toString(): string
    {
        return "Cylinder[{$this->circleToString()},height={$this->height}]";
    }
}

>