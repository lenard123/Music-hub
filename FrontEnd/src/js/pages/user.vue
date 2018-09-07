<template>
	<router-view></router-view>
</template>

<style>

/************
 * CSS grid *
 ************/
@import '../../css/grid.css';

/**************************
 * Modify Built-in Design *
 **************************/
body {
	margin: 0;
	padding: 0;
	color: #4a4a4a;
	font-size: 1rem;
	font-weight: 400;
	line-height: 1.5;
}

a {
	color: #3273dc;
	cursor: pointer;
	text-decoration: none;
}

img {
	height: auto;
	max-width: 100%;
}

/******************
 * Navigation Bar *
 ******************/

.navbar {
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

.navbar-left > .navbar-item {
	float: left;
}

.navbar-right > .navbar-item {
	float: right;
}

.navbar-item {
	display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;	
}

.navbar-item:hover{
	background-color: #111;
}

.navbar-item.active1{
	background-color: #4CAF50;
}


/*********
 * Notes *
 *********/
.notes {
    margin: 15px;
    padding: 4px 12px;
}

.notes.danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
}

.notes.success {
    background-color: #ddffdd;
    border-left: 6px solid #4CAF50;
}

.notes.info {
    background-color: #e7f3fe;
    border-left: 6px solid #2196F3;
}


.notes.warning {
    background-color: #ffffcc;
    border-left: 6px solid #ffeb3b;
}

/*********
 * Image *
 *********/
.img-circle {
	border-radius: 50%;
}

/*********
 * Table *
 *********/
.table {
	border-collapse: collapse;
	width: 100%;
}

.table > thead > tr > th, .table > tbody > tr > td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table-hover > tbody > tr:hover {
	background-color:#f5f5f5;
}

/*****************
 * Custom Design *
 *****************/
.page {
	margin: 15px;
	padding: 15px;
}
</style>
