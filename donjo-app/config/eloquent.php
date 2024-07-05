<?php



use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Facade;

Carbon::setLocale('id');
CarbonImmutable::setLocale('id');
CarbonPeriod::setLocale('id');
CarbonInterval::setLocale('id');

$capsule = new Capsule();
$capsule->addConnection([
    'driver'    => $db['default']['dbdriver'] == 'mysqli' ? 'mysql' : $db['default']['dbdriver'],
    'host'      => $db['default']['hostname'],
    'port'      => $db['default']['port'],
    'database'  => $db['default']['database'],
    'username'  => $db['default']['username'],
    'password'  => $db['default']['password'],
    'charset'   => $db['default']['char_set'],
    'collation' => $db['default']['dbcollat'],
    'prefix'    => $db['default']['dbprefix'],
    'stricton'  => $db['default']['stricton'],
    'options'   => [
        \PDO::ATTR_EMULATE_PREPARES => true,
    ],
]);
$capsule->setAsGlobal();
$capsule->setEventDispatcher(new Dispatcher());
$capsule->bootEloquent();
$capsule->getContainer()->singleton('db', static function () use ($capsule) {
    return $capsule->getDatabaseManager();
});

Facade::clearResolvedInstances();
Facade::setFacadeApplication($capsule->getContainer());

Paginator::$defaultView       = 'admin/layouts/components/pagination_default';
Paginator::$defaultSimpleView = 'admin/layouts/components/pagination_simple_default';

Paginator::viewFactoryResolver(static function () {
    return view();
});

Paginator::currentPathResolver(static function () {
    return current_url();
});

Paginator::currentPageResolver(static function ($pageName = 'page') {
    $page = get_instance()->input->get($pageName);

    if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
        return (int) $page;
    }

    return 1;
});

Paginator::queryStringResolver(static function () {
    return get_instance()->uri->uri_string();
});

CursorPaginator::currentCursorResolver(static function ($cursorName = 'cursor') {
    return Cursor::fromEncoded(get_instance()->input->get($cursorName));
});

\Illuminate\Database\Query\Builder::macro('toRawSql', function () {
    return array_reduce($this->getBindings(), static function ($sql, $binding) {
        return preg_replace('/\?/', is_numeric($binding) ? $binding : "'{$binding}'", $sql, 1);
    }, $this->toSql());
});

\Illuminate\Database\Eloquent\Builder::macro('toRawSql', function () {
    return $this->getQuery()->toRawSql();
});
