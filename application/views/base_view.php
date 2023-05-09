<h1>Список задач</h1>
<p>

    <select class="form-select" aria-label="Пример выбора по умолчанию" id="select_sort" style="width: 30%;">
        <option value="default" selected>Сортировка по умолчанию</option>
        <option value="name_a">Имя пользователя возр.</option>
        <option value="name_z">Имя пользователя убыв.</option>
        <option value="email_a">E-mail возр.</option>
        <option value="email_z">E-mail убыв.</option>
        <option value="text_a">Текст задачи возр.</option>
        <option value="text_z">Текст задачи убыв.</option>
        <option value="status_a">Статус возр.</option>
        <option value="status_z">Статус убыв.</option>
    </select>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Имя пользователя</th>
        <th scope="col">E-mail</th>
        <th scope="col">Текст задачи</th>
        <th scope="col">Статус</th>
        <?php

        if($this->session){
            echo '<th scope="col">-</th>';
        }

        ?>
    </tr>
    </thead>
    <tbody>

    <?php

    for($a=0; $a<count($data["list"]); $a++)
    {

        $status = ($data["list"][$a]["status"] != null) ? 'V' : 'X';

        $edit = '';

        if($this->session){
            $edit = '<td><button class="btn btn-primary mb-3 edit_form" text_row="'.$data["list"][$a]["text"].'" status_row="'.$data["list"][$a]["status"].'" id_row="'.$data["list"][$a]["id"].'">Ред.</button></td>';
        }


        echo '    <tr>
        <td>'.$data["list"][$a]["name"].'</td>
        <td>'.$data["list"][$a]["email"].'</td>
        <td>'.$data["list"][$a]["text"].'</td>
        <td>'.$status.'</td>
        '.$edit.'
    </tr>';
    }

    ?>


    <tr>
        <td><input type="text" class="form-control" data-name="name"></td>
        <td><input type="text" class="form-control" data-name="email"></td>
        <td><input type="text" class="form-control" data-name="text"></td>
        <td></td>
    </tr>

    </tbody>
</table>

<button type="submit" class="btn btn-primary mb-3" id="save">Сохранить</button>

<?php

if($data["count"] > 3){
    $kol_vo = ceil($data["count"] / 3);

    for($a=0; $a<$kol_vo; $a++){
        echo '<button class="btn btn-primary mb-3 next_btn" id="next_'.($a + 1).'">'.($a + 1).'</button>';
    }
}

?>

</table>
</p>
