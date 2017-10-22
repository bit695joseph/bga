<?php
require_once __DIR__ . '/../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_MODELS_DIR . 'Member.php';
require_once SRC_DATA_DIR . 'Result.php';

use \bga\app\App;
use \bga\app\data\Member as Member;
?>
<?php

    App::setPageTitle("Members");
    App::setActivePage("Members");
    App::setBreadcrumbs("Members");
    App::setClientPageData([
        'model' => 'Member',
        'crud' => 'list'
    ]);

    $foundMembers = Member::findAll();
?>
<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">

    <div class="row">

        <div class="col">
            <h1>Members <button type="button" class="btn btn-success btn-sm create-btn">Create New</button></h1>

            <?php if ($foundMembers->success()): ?>
            <br>
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($foundMembers->models() as $m): ?>
                        <tr id="<?php App::e($m->member_id); ?>" scope="row">
                            <td><?php App::e($m->member_id); ?></td>
                            <td><?php App::e($m->first_name); ?></td>
                            <td><?php App::e($m->last_name); ?></td>
                            <td><?php App::e($m->email); ?></td>
                            <td><?php App::e($m->phone); ?></td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm edit-btn row-btn">Edit</button>
                                <button type="button" class="btn btn-secondary btn-sm games-btn row-btn" title="Add and remove games">Games</button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn row-btn">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>


                    </tbody>
                </table>

            <?php elseif ($foundMembers->none()): ?>
                <i>There are no members in the database.</i>
            <?php else: ?>
                <i><?php $foundMembers->message(); ?></i>
            <?php endif; ?>

        </div>
    </div>

</div>






<?php include VIEWS_DIR . 'bottom.php'; ?>