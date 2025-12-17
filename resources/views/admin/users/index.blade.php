@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3>Пользователи</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <table class="table table-bordered table-striped" id="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr class="user-row active">
                    <td>1</td>
                    <td>Иван Иванов</td>
                    <td>ivan@mail.com</td>
                    <td class="status">Активен</td>
                    <td>
                        <button class="btn btn-sm btn-danger ban-btn">Забанить</button>
                        <button class="btn btn-sm btn-success unban-btn">Разбанить</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
/* Основные цвета строк */
.user-row.active { background-color: #d4edda; transition: all 0.3s; }
.user-row.banned { background-color: #f8d7da; transition: all 0.3s; }

/* Горящий эффект по бокам */
.user-row.banned::before, .user-row.banned::after {
    content: '';
    position: absolute;
    top: 0;
    width: 5px;
    height: 100%;
    background: red;
}
.user-row.banned::before { left: 0; }
.user-row.banned::after { right: 0; }

.user-row.active::before, .user-row.active::after {
    content: '';
    position: absolute;
    top: 0;
    width: 5px;
    height: 100%;
    background: green;
}
.user-row.active::before { left: 0; }
.user-row.active::after { right: 0; }

table { position: relative; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const banButtons = document.querySelectorAll('.ban-btn');
    const unbanButtons = document.querySelectorAll('.unban-btn');

    banButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            row.classList.add('banned');
            row.classList.remove('active');
            row.querySelector('.status').innerText = 'Забанен';
        });
    });

    unbanButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            row.classList.add('active');
            row.classList.remove('banned');
            row.querySelector('.status').innerText = 'Активен';
        });
    });
});
</script>
@endsection
