# Project Setup

<img src="https://cdn.allfamous.org/people/headshots/pumba-caracal-hq5d-1644288306534-allfamous.org.jpg" alt="My Logo" width="200"/>

## สร้างฐานข้อมูล customers เลือก utf8_general_ci

เพื่อสร้างฐานข้อมูล `customers` และเลือกการตั้งค่าการเข้ารหัสเป็น `utf8_general_ci` คุณสามารถใช้คำสั่ง SQL ดังนี้:

```sql
CREATE DATABASE customers CHARACTER SET utf8 COLLATE utf8_general_ci;
