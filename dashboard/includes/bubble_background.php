<?php
// Incluye este archivo y llama a renderBubbleBackground() donde quieras el fondo
function renderBubbleBackground() {
    echo '<div class="bubble-background">';
    for ($i = 0; $i < 10; $i++) {
        echo '<div class="bubble"></div>';
    }
    echo '</div>';
}
