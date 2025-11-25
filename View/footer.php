<?php
class Footer{
    //ATTRIBUT
    private string $content = '';

    //CONSTRUCTEUR
    public function __construct(){}
    //GETTER ET SETTER
    public function getContent():string{
        return $this->content;
    }

    public function setContent(string $newContent):Footer{
        $this->content = $newContent;
        return $this;
    }

    //METHOD
    public function renderFooter(){
        return "</main>
                <footer>
                    ".$this->getContent();
                    "
                </footer>
            </body>
            </html>";
    }
}
?>

