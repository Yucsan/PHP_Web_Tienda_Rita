<?php 
    
    $sqlProductos ="
        SELECT * 
            FROM producto;
    ";
    $queryProductos = mysqli_query($conectar, $sqlProductos);
    
    $like = 0;
    while ($rowqueryProductos = mysqli_fetch_assoc($queryProductos)){
        
?> 

<!-- CARTA -->
      <div class="card cuadro1" style="">
        <img src="<?php echo $rowqueryProductos['foto_producto']?>" style="border: solid 10px #EDBC41" class="card-img-top" alt="cuadro">
        <div class="card-body" style="display: flex; justify-content: end; flex-direction: column;">
        
            <i class="far fa-heart likeCard" id="play<?php echo "$like"; ?>" style="cursor: pointer; color: gray; text-align: center" onclick = "funcLike(<?php echo "$like"; ?>)">&nbsp;<span class="melike<?php echo "$like"; ?>" style="font-size:14px; font-family: muli;"></span></i>
            <?php echo "<script>var estado".$like." = false; conteEstados.push(estado".$like."); </script>"; ?>
            
            <h5 class="card-title" style="color: var(--morado);">Geranios en primavera</h5>
            <p class="card-text">Cuadro de estilo Naif inspirado en la primavera. <br>
                <span style="color:var(--morado)">Medidas:</span><span> 32 cm x 32 cm </span><br>
                <span style="color:var(--morado)">Material:</span><span> Acrilico</span>
            </p>

        <div style="background: none; position: relative;">
        <a href="#" class="btn botonCarta">ver cuadro</a>

                <div class="tooltipCustom">

              <i style="position: absolute; right: 0px; bottom: 0px;" class="fas fa-shopping-cart carritoCarta"></i>
              <span class="tooltiptext">Añade a la Cesta</span>
            </div>
          </div>

        </div>
      </div>

<?php 
        $like++;
    }

?> 