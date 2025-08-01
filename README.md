#  在线电影网站推荐系统 | Online Movie Recommendation System

一个基于 PHP + MySQL 实现的原生电影网站推荐平台，支持用户注册、登录、浏览电影、推荐记录与详情查看等功能。所有页面均使用原生 HTML + CSS 构建，简洁易懂，适合作为学习项目或展示作品。

>  在线仓库地址：[GitHub - likucy/movie-recommendation](https://github.com/likucy/movie-recommendation)

---

## 项目亮点 Highlights

-  **用户模块**：注册 / 登录 / 注销，使用验证码验证注册安全性
-  **电影展示**：支持电影封面、本地图片、评分、分类、国家、年份等信息
-  **电影详情页**：点击每部电影可查看详细信息
-  **推荐记录功能**：保存用户推荐过的电影（可扩展个性推荐逻辑）
-  **完全原生技术栈**：无框架依赖，利于掌握基础后端逻辑
-  **封面本地存储**：全部电影封面图已迁移至本地 image 文件夹，加载更稳定

---

##  技术栈 Stack

| 层级     | 使用技术      |
|----------|----------------|
| 前端     | HTML + CSS (style1.css & style2.css) |
| 后端     | PHP（无框架）  |
| 数据库   | MySQL（movie_db） |
| 部署     | 本地 Apache 或 PHP 内建服务器 |

---

##  目录结构简览

movie-recommendation/
├── index.php # 主页
├── conn.php # 数据库连接
├── deng.php / deng.html # 登录功能
├── zhuce.php / zhuce.html # 注册功能（含验证码）
├── yzm.php # 验证码生成
├── dianying.php # 电影列表页
├── movie_detail.php # 电影详情页
├── movie_list.php # 推荐记录展示
├── delete_account.php # 注销账号处理
├── logout.php # 退出登录
├── image/ # 存放电影本地封面图（已下载）
├── style1.css / style2.css # 页面样式
└── ...

##  使用方式（本地运行）

1. 克隆项目：
   ```bash
   git clone https://github.com/likucy/movie-recommendation.git

2. 启动本地 PHP 环境（推荐使用 XAMPP/WAMP）

3. 将项目放入 htdocs 目录中，访问：http://localhost/movie-recommendation/index.php

4. 导入数据库：使用 phpMyAdmin 或命令行导入项目中的 movie_db.sql 文件

作者信息   lkh

 GitHub: @likucy

本项目使用 MIT License 开源，你可以自由学习、使用、修改和分发。
