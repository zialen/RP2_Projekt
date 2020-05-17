<?php 
// usklađeno sa novom bazom
class Food{

    protected $id_food, $name, $description, $waiting_time, $price, $id_restaurant ;

    public function __construct($id, $name, $description, $waiting_time, $id_restaurant, $price)
    {
        $this->id_food = $id;
        $this->name = $name;
        $this->description = $description;
        $this->waiting_time = $waiting_time;
        $this->id_restaurant = $id_restaurant;
        $this->price = $price;
    }

    public function __get( $property )
    {
        if( property_exists($this, $property))
            return $this->$property;
    }

    public function __set( $property, $value )
    {
        if( property_exists( $this, $property ) )
            $this->$property = $value;
        return $this;
    }

}

?>