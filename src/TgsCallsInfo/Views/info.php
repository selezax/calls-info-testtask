<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Customer Id</th>
                    <th scope="col">Number of calls within the same continent</th>
                    <th scope="col">Total Duration of calls within the same continent</th>
                    <th scope="col">Total number of all calls</th>
                    <th scope="col">The total duration of all calls</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $data = $params['data'];
                foreach ($data->getCustomersList() as $customerId):
                    $customer = $data->getCustomerById($customerId);
                    $byContinent = $customer->calculatingByContinent();
                    ?>
                <tr>
                    <th scope="row"><?php echo $customerId ?></th>
                    <td><?php foreach ($byContinent as $c=>$bi): ?>
                            <span class="text-info"><?php echo $c ?>:</span>
                            <span ><?php echo $bi['number'] ?></span>
                            <br/>
                        <?php endforeach; ?>
                        <strong>Total: <?php echo array_sum(array_column($byContinent, 'number')) ?></strong>
                    </td>
                    <td><?php foreach ($byContinent as $c=>$bi): ?>
                            <span class="text-info"><?php echo $c ?>:</span>
                            <span ><?php echo $bi['duration'] ?>s.</span>
                            <span class="text-secondary"><?php echo $customer->convertSecondToFullTime($bi['duration']) ?></span>
                            <br/>
                    <?php endforeach; ?>
                        <strong>Total: <?php echo array_sum(array_column($byContinent, 'duration')) ?>s.</strong>
                    </td>
                    <td><?php echo $customer->totalNumberAllCalls ?></td>
                    <td>
                        <?php echo $time = $customer->totalDurationAllCalls ?>&nbsp;s.<br/>
                        <?php echo $customer->convertSecondToFullTime($time) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>