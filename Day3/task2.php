<?php

class Account
{
    private string $id;
    private string $name;
    private int $balance;

    function __construct(string $id, string $name, int $balance = 0){
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getBalance(){
        return $this->balance;
    }

    public function credit(int $amount){
        $this->balance += $amount;
        return $this->balance;
    }

    public function debit(int $amount){
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
        } else {
            echo "Amount exceeded balance<br>";
        }
        return $this->balance;
    }

    public function transferTo(Account $destAcc, int $amount){
        if ($amount <= $this->balance) {
            $this->debit($amount);
            $destAcc->credit($amount);
        } else {
            echo "Amount exceeded balance<br>";
        }
        return $this->balance;
    }

    public function __toString(){
        return "Account[id={$this->id},name={$this->name},balance={$this->balance}]";
    }
}


// ! Q2 ! //
class Ball
{
    private float $x;
    private float $y;
    private int $radius;
    private float $xDelta;
    private float $yDelta;

    public function __construct(float $x, float $y, int $radius, float $xDelta, float $yDelta){
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
        $this->xDelta = $xDelta;
        $this->yDelta = $yDelta;
    }

    public function getX(){
        return $this->x;
    }
    public function setX(float $x){
        $this->x = $x;
    }

    public function getY(){
        return $this->y;
    }
    public function setY(float $y){
        $this->y = $y;
    }

    public function getRadius(){
        return $this->radius;
    }
    public function setRadius(int $radius){
        $this->radius = $radius;
    }

    public function getXDelta(){
        return $this->xDelta;
    }
    public function setXDelta(float $xDelta){
        $this->xDelta = $xDelta;
    }

    public function getYDelta(){
        return $this->yDelta;
    }
    public function setYDelta(float $yDelta){
        $this->yDelta = $yDelta;
    }

    public function move(){
        $this->x += $this->xDelta;
        $this->y += $this->yDelta;
    }

    public function reflectHorizontal(){
        $this->xDelta = -$this->xDelta;
    }
    public function reflectVertical(){
        $this->yDelta = -$this->yDelta;
    }

    public function __toString(){
        return "Ball[({$this->x},{$this->y}),speed=({$this->xDelta},{$this->yDelta})]";
    }
}