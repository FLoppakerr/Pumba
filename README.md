# Project Setup

![My Logo]([https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjZrGqPl9HZLGoLLj7k6_hYl5PoPJ88ezuwnLjZS_icyA12mkpsqp6Yx9f0m_0qEXvLWVBazrCg3EWi5vNBcnTiJ6UsWhYVLasM2n9yIoTRYv0ETHQzDPRnAUezNfiTbwFQ_gWFq6ymld7iao7zOJQv61rcta_tu8D765nVgJzjVpIaeHepGuY9v2qn/w74-h74-p-k-no-nu/pumba.jpg](https://cdn.allfamous.org/people/headshots/pumba-caracal-hq5d-1644288306534-allfamous.org.jpg))

## สร้างฐานข้อมูล customers เลือก utf8_general_ci

เพื่อสร้างฐานข้อมูล `customers` และเลือกการตั้งค่าการเข้ารหัสเป็น `utf8_general_ci` คุณสามารถใช้คำสั่ง SQL ดังนี้:

```sql
CREATE DATABASE customers CHARACTER SET utf8 COLLATE utf8_general_ci;
