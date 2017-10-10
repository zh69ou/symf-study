
php bin/console generate:bundle --namespace=Acme/TestBundle

# 模板语法检查
# 你可以检查文件名:
$ php bin/console lint:twig app/Resources/views/article/recent_list.html.twig
# 或目录:
$ php bin/console lint:twig app/Resources/views

php bin/console cache:clear --env=prod --no-debug

php bin/console generate:bundle --namespace=Acme/TestBundle

php bin/console doctrine:database:create
php bin/console doctrine:database:drop --force

php bin/console doctrine:generate:entity

php bin/console doctrine:generate:entities AppBundle/Entity/Product
php bin/console doctrine:generate:entities AppBundle

php bin/console doctrine:schema:update --force

php bin/console security:check

php bin/console cache:clear

composer dump-autoload

-------------------------------------list--------------
Available commands:
  help                                    显示命令的帮助信息
  list                                    列表命令
 assets
  assets:install                          安装包网络资产公共web目录
 cache
  cache:clear                             清空缓存
  cache:warmup                            温和清理缓存
 config
  config:dump-reference                   转储文件的默认配置一个扩展
 debug
  debug:config                            转储当前配置的扩展
  debug:container                         显示当前的服务应用程序
  debug:event-dispatcher                  显示为应用程序配置监听器
  debug:router                            显示当前路线为应用程序
  debug:swiftmailer                       显示当前邮件应用程序
  debug:translation                       显示消息翻译信息
  debug:twig                              显示了一个树枝的列表功能,过滤器,全局和测试
 doctrine
  doctrine:cache:clear-collection-region  Clear a second-level cache collection region.
  doctrine:cache:clear-entity-region      Clear a second-level cache entity region.
  doctrine:cache:clear-metadata           Clears all metadata cache for an entity manager
  doctrine:cache:clear-query              Clears all query cache for an entity manager
  doctrine:cache:clear-query-region       Clear a second-level cache query region.
  doctrine:cache:clear-result             Clears result cache for an entity manager
  doctrine:database:create                创建配置的数据库
  doctrine:database:drop                  Drops the configured database
  doctrine:ensure-production-settings     Verify that Doctrine is properly configured for a production environment.
  doctrine:generate:crud                  Generates a CRUD based on a Doctrine entity
  doctrine:generate:entities              Generates entity classes and method stubs from your mapping information
  doctrine:generate:entity                Generates a new Doctrine entity inside a bundle
  doctrine:generate:form                  Generates a form type class based on a Doctrine entity
  doctrine:mapping:convert                Convert mapping information between supported formats.
  doctrine:mapping:import                 Imports mapping information from an existing database
  doctrine:mapping:info
  doctrine:query:dql                      Executes arbitrary DQL directly from the command line.
  doctrine:query:sql                      Executes arbitrary SQL directly from the command line.
  doctrine:schema:create                  Executes (or dumps) the SQL needed to generate the database schema
  doctrine:schema:drop                    Executes (or dumps) the SQL needed to drop the current database schema
  doctrine:schema:update                  Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata.
  doctrine:schema:validate                Validate the mapping files.
 generate
  generate:bundle                         Generates a bundle
  generate:command                        Generates a console command
  generate:controller                     Generates a controller
  generate:doctrine:crud                  Generates a CRUD based on a Doctrine entity
  generate:doctrine:entities              Generates entity classes and method stubs from your mapping information
  generate:doctrine:entity                Generates a new Doctrine entity inside a bundle
  generate:doctrine:form                  Generates a form type class based on a Doctrine entity
 lint
  lint:twig                               Lints a template and outputs encountered errors
  lint:yaml                               Lints a file and outputs encountered errors
 orm
  orm:convert:mapping                     Convert mapping information between supported formats.
 router
  router:match                            Helps debug routes by simulating a path info match
 security
  security:check                          Checks security issues in your project dependencies
  security:encode-password                Encodes a password.
 server
  server:run                              Runs PHP built-in web server
  server:start                            Starts PHP built-in web server in the background
  server:status                           Outputs the status of the built-in web server for the given address
  server:stop                             Stops PHP's built-in web server that was started with the server:start command
 swiftmailer
  swiftmailer:debug                       Displays current mailers for an application
  swiftmailer:email:send                  Send simple email message
  swiftmailer:spool:send                  Sends emails from the spool
 translation
  translation:update                      Updates the translation file