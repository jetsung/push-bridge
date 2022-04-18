# PUSH-BRIDGE
消息推送整合平台

## 开发
### 测试环境
```bash
php artisan serve
```

## 布署
```bash
# 先执行 
composer install

# 创建 .env 文件内容为
echo "APP_KEY=" > .env
# 或
cp .env.example .env

# 再执行
php artisan route:clear

php artisan cache:clear
php artisan config:cache

php artisan config:clear
php artisan view:clear
php artisan key:generate

# storage
## 若 775 权限依然无法访问时
chmod -R 777 storage
```

## NGINX 设置
```bash
    # 入口在当前项目的 public
    root project/public

    # 隐藏 index.php 入口
    location / {
      try_files $uri $uri/ /index.php?$query_string;
    }
```

## 更新 composer.json autoload
```bash
composer dump-autoload -o
```

## 
- 基于 [Laravel](https://laravel.com/) 开发框架
