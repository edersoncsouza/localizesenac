
                            <p><b> Outros Serviços </b></p>

                            <div id="conteudo_mostrar_servicos">
                                <script>
                                    $ajax.ready(function () {
                                        $.ajax({
                                            url: 'servicos.php?cd_andar=3',
                                            async: true
                                        }).done(function (data) {
                                            alert(data);
                                        });
                                    }
                                </script>
                            </div>

                            <?php
                            echo "<p>";
                            if (isset($_GET['cd_andar'])) {
                                $sql5 = "SELECT 
                                        CONCAT (NR_MAPA,' - ', NM_LOCAL) AS DS_LOC
                                    FROM parametro_imagem I,
                                        andar_locais A
                                    WHERE
                                        I.CD_ANDAR = A.CD_ANDAR
                                        AND
                                        I.CD_PARAMETRO = $cd_andar ORDER BY NR_MAPA";
                                $result5 = mysql_query($sql5, $_SG['link']);
                                while ($consulta5 = mysql_fetch_array($result5)) {
                                    echo "$consulta5[DS_LOC]\n";
                                    echo "</br>";
                                }
                                echo "</p>";
                            }
                            ?>  
