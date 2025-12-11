<?php
    require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

    use Application\Core\Factory;
    use Application\Controllers\ReportersController;

    /** @var ReportersController $reportersController */
    $reportersController = Factory::create(ReportersController::class);
    // $reportersController->init();

    echo '<pre>'. print_r($_SERVER, true) .'</pre>';
?>
<?php if (!isset($_GET['action'])): ?>

    <h2>Lista</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>John</td>
                <td>Doe</td>
                <td>@social</td>
            </tr>
        </tbody>
    </table>

<?php endif; ?>
<?php if (isset($_GET['action']) && $_GET['action'] === 'view'): ?>

    <h2>Formulário</h2>
    
<?php endif; ?>