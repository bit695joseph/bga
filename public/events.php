<?php
    require_once __DIR__ . '/../app/config.php';
    require_once SRC_DIR . 'App.php';
    require_once SRC_MODELS_DIR . 'Event.php';
    require_once SRC_DATA_DIR . 'Result.php';
    use \bga\app\App;
    use \bga\app\data\Event;

    App::setPageTitle("Events");
    App::setActivePage("Events");
    App::setBreadcrumbs("Events");
    App::setClientPageData([
        'model' => 'Event',
        'crud' => 'list'
    ]);
    $foundEvents = Event::findAll();
?>


<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">

    <div class="row">

        <div class="col">
            <h1>Events <button type="button" class="btn btn-success btn-sm create-btn">Create New</button></h1>

            <?php if ($foundEvents->success()): ?>
            <br>
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th>Venue</th>
                        <th>Scheduled</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($foundEvents->models() as $g): ?>
                        <tr id="<?php App::e($g->event_id); ?>" scope="row">
                            <td><?php App::e($g->venue); ?></td>
                            <td><?php App::e($g->scheduled); ?></td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm edit-btn row-btn">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn row-btn">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>


                    </tbody>
                </table>

            <?php elseif ($foundEvents->none()): ?>
                <i>There are no events in the database.</i>
            <?php else: ?>
                <i><?php $foundEvents->message(); ?></i>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>