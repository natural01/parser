**server start**
1. Сервер запускаеться через консоль командой:
   - php index.php **2023-12-01** **2023-12-02**

**Data Base**
1. В проекте используеться платформа **Open Server**
   - подключение к localhost происходит в конструкторе класса **DataBase**
   - код для создания таблиц:


     - CREATE TABLE `hotel` (
       `name` varchar(255) NOT NULL,
       `address` text NOT NULL,
       `grade` int(11) NOT NULL,
       `imgSrc` text NOT NULL,
       `postingDate` int(11) NOT NULL,
       `hotelSrc` text NOT NULL
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8
      

     - CREATE TABLE `price` (
       `name` varchar(255) NOT NULL,
       `site` varchar(255) NOT NULL,
       `price` varchar(10) NOT NULL
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8