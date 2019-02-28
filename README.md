Summary for YML(Yandex Market Language)
===========

The script builds a report on the structure of the YML file.
An example at the end of the readme.


# Usage
```
php summary.php [path-to-yml-file] [translation=en]
```
e.g
```
php summary.php shoes_shop.xml
```
with custom locale
```
php summary.php shoes_shop.xml ru
```

# Available locales
+ en (English)
+ ru (Russian)

# Example
```text
Shop name: Eurogalant.Ru
Company name: Интернет-магазин «Еврогалант»
Company link: https://eurogalant.ru/
============ Categories ============
Total roots: 4
Total categories: 57
А
Аксессуары, Аксессуары и чехлы
Б
Багаж, Брелоки, Бьюти-кейсы
В
Визитницы
Г
Головные уборы
Д
Деловые сумки, Детская, Длинный рукав, Для женщин, Для мужчин, Дорожные сумки
З
Зажимы для денег, Защитные покрытия, Зонты
К
Кейс-пилоты, Клатчи, Ключницы, Короткий рукав, Косметички, Кошельки
М
Монетницы
Н
Напоясные сумки, Несессеры
О
Обложки для документов, Органайзеры, Очёчники
П
Палантины и шарфы, Папки для документов, Подтяжки, Портмоне, Портфели, Портфели и деловые сумки
Р
Распродажа, Ремни, Рюкзаки
С
Сорочка, Сумки, Сумки для планшета, Сумки-планшеты
Ч
Чемоданы на колёсах
=============== Signs ==============
1. Delivery
2. Link to product
3. Product price
4. Bulk price
5. Model
6. Barcode
7. Description
8. Manufacturer
9. Product item
10. Product type
11. Product images
12. Product id
13. Высота (см)
14. Высота ручек (см)
15. Глубина (см)
16. Длина (см)
17. Максимальная высота выдвижной ручки (см)
18. Толщина (см)
19. Ширина (см)
=============== Statistic ==============
Available products: 2863 / 2863
Avg pictures per product: 4.45
```
