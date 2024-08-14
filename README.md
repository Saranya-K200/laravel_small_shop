# laravel_small_shop
 
## Setup Instructions

### Prerequisites
Ensure you have PHP installed. You can download it from [XAMPP](https://www.apachefriends.org/).

Ensure you have composer installed. You can download it from [composer](https://getcomposer.org/).

Ensure you have visual studio code installed. You can download it from [vs code](https://code.visualstudio.com/).

### Go to Terminal 

1. **Creating a Laravel Project**
    ```
    composer create-project laravel/laravel laravel_small_shop
    ```

4. **navigate to project folder**
    ```
    cd laravel_small_shop
    ```

6. **run the app**
    ```
    php artisan serve
    ```


4. **create category model**
    ```
    php artisan make:model Category -m
    ```

4. **create brand model**
    ```
    php artisan make:model Brand -m
    ```

4. **create product model**
    ```
    php artisan make:model Product -m
    ```

4. **create cart model**
    ```
    php artisan make:model Cart -m
    ```

 4. **create order model**
    ```
    php artisan make:model Order -m
    ```

4. **create order item model**

    ```
    php artisan make:model OrderItem -m
    ```   
       
7. **migrate fresh**
    ```
    php artisan migrate:fresh
    ```

8. **db seed**
    ```
    php artisan db:seed
    ```

9. **generate category resource**
    ```
    php artisan make:filament-resource Category --generate
    ```

9. **generate brand resource**
    ```
    php artisan make:filament-resource Brand --generate
    ```

9. **generate product resource**
    ```
    php artisan make:filament-resource Product --generate
    ```

9. **generate cart resource**
    ```
    php artisan make:filament-resource Cart --generate
    ```

9. **generate order resource**
    ```
    php artisan make:filament-resource Order --generate
    ```    

9. **generate order item resource**
    ```
    php artisan make:filament-resource OrderItem --generate
    ``` 

[dom pdf Library](https://github.com/dompdf/dompdf)
```
composer require dompdf/dompdf
```

4. **generate invoice controller**
```
php artisan make:controller InvoiceController
```

