## 说明
Laravel版本：10.10

## 伪静态配置
### Nginx
```nginx
location / {
    index  index.html index.htm index.php;
    if (!-e $request_filename) {
        rewrite  ^(.*)$  /index.php?s=/$1  last;
        break;
    }
}
```

## 部署
- 配置好nginx后，命令行使用命令 
  - php artisan key:generate
- 执行迁移文件，建立表 
  - php artisan migrate
- 执行种子文件，建立初始化用户数据 
  - php artisan db:seed --class=UserSeeder
