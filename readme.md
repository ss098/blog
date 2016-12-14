这是一个 Laravel 5.3 + Vue 2 写的 Markdown 博客系统，使用 localStorage 作为客户端缓存。

你可以在我的博客 [https://www.qiyichao.cn/](https://www.qiyichao.cn/) 查看效果。

## 部署项目 ##

拷贝代码到本地。

    git clone git@github.com:ss098/blog.git

你需要先安装依赖环境。

    composer install
    npm install

在网络环境不好的时候，你可以用 cnpm 来代替 npm。然后我们编译前端代码。

    npm run prod

手动导入 blog.sql 到数据库，然后配置数据库连接。

    cp .env.example .env
    php artisan key:generate
    
编辑其中的数据库部分。

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=blog
    DB_USERNAME=blog
    DB_PASSWORD=blog

然后配置 nginx 的伪静态。

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

看到这么多条步骤 ... 我都不太想安装了。