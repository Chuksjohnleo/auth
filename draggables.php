<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'src/header.php';
    ?>
    <title>Draggable Box</title>
    <style>
        .draggable-box {
            width: 60px;
            height: 60px;
            position: absolute;
            cursor: move;
            border-radius: 9999px;
            /* background-color: blue; */
        }
    </style>
</head>

<body>
    <?php
    include 'src/nav.php';
    ?>
    <div id="box1" class="draggable-box bg-primary-color"></div>
    <div id="box2" class="draggable-box border-2 border-yellow-700"></div>
    <div id="box3" class="draggable-box bg-green-700"></div>
    <div id="box4" class="draggable-box bg-red-700"></div>
    <div id="box5" class="draggable-box bg-black"></div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const draggableBoxes = document.querySelectorAll('.draggable-box');
        draggableBoxes.forEach(box => {
            let isDragging = false;
            let offsetX = 30;
            let offsetY = 30;

            if (sessionStorage.getItem(`box-left-${box.id}`) &&
                sessionStorage.getItem(`box-top-${box.id}`)) {
                box.style.left = sessionStorage.getItem(`box-left-${box.id}`);
                box.style.top = sessionStorage.getItem(`box-top-${box.id}`);
            }
            const startDragging = (e) => {
                isDragging = true;
                //I don't know where gpt got the codes below but it's alright.
                // offsetX = e.clientX || e.touches[0].clientX - box.getBoundingClientRect().left;
                // offsetY = e.clientY || e.touches[0].clientY - box.getBoundingClientRect().top;
            };

            const drag = (e) => {
                if (isDragging) {
                    e.preventDefault();
                    box.style.left = (e.clientX || e.touches[0].clientX) - offsetX + 'px';
                    box.style.top = (e.clientY || e.touches[0].clientY) - offsetY + 'px';
                    sessionStorage.setItem(`box-left-${box.id}`, box.style.left);
                    sessionStorage.setItem(`box-top-${box.id}`, box.style.top);
                }
            };

            const stopDragging = () => {
                isDragging = false;
            };

            box.addEventListener('mousedown', startDragging);
            box.addEventListener('touchstart', startDragging);

            document.addEventListener('mousemove', drag);
            document.addEventListener('touchmove', drag);

            document.addEventListener('mouseup', stopDragging);
            document.addEventListener('touchend', stopDragging);
        });});
    </script>

</body>

</html>