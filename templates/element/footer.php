<footer class="site-footer pt-5 mt-5 pb-5" style= "background-color:#f8f9fa;">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 footer-about wow fadeInUp">
                        <h3>A propos de Nestlé</h3>
                        <p>
                                Nestlé est une multinationale suisse et l'un des principaux acteurs de l'industrie agroalimentaire de la planète.
                        </p>
                        <p>&copy; Nestlé</p>
                    </div>
                    <div class="col-md-4 offset-md-1 footer-contact wow fadeInDown">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Rue du chocolat 23, 1000 Bruxelles</p>
                    <p><i class="fas fa-phone"></i> Tél: (0039) 333 12 68 347</p>
                    <p><i class="fas fa-envelope"></i> Email: <a href="mailto:info@nestle.be">info@nestle.be</a></p>
                    <p><i class="fab fa-skype"></i> Skype: nestle_online</p>
                    </div>
                    <div class="col-md-4 footer-links wow fadeInUp">
                        <div class="row">
                            <div class="col">
                                <h3>Liens</h3>
                            </div>
                        </div>
                    <div class="row">
                    <div class="col-md-6">
                        <p><?= $this->Html->link('Accueil', '/'); ?></p>
                        <p><?= $this->Html->link('Departements', '/departments'); ?></p>
                        <p><?= $this->Html->link('Women at work', '/women_at_work'); ?></p>
                        <p><?= $this->Html->link('Partenaires', '/partners'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><?= $this->Html->link('Connexion', '#connexion', ['data-bs-toggle' => "modal", 'data-bs-target' => "#connexion"]); ?></p>
                        <p><?= $this->Html->link('Déconnexion', '/users/logout'); ?></p>
                        <p><?= $this->Html->link('S\'inscrire', '/pages/register'); ?></p>
                        <p><a href="#">Offres d'emplois</a></p>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a> 
                        <a href="#"><i class="fab fa-twitter"></i></a> 
                        <a href="#"><i class="fab fa-google-plus-g"></i></a> 
                        <a href="#"><i class="fab fa-instagram"></i></a> 
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
</footer>