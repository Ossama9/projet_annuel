package controller.asso;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;

import persistence.Asso;


public class ControllerAsso extends ControllerOne {

    public Asso asso;

    public void initData(Asso asso){
        if( asso != null )
            this.asso = asso;

        else
            goToLandingPage();
    }

    //redirection button action
    @FXML
    public void goToAssoIndex(ActionEvent event){
        loadAssoIndex(event, asso);
    }

    @FXML
    public void goToAssoNewProject(ActionEvent event){
        ControllerOne.loadAssoNewProjectStage(event, asso);
    }


}
