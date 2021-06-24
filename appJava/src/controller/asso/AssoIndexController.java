package controller.asso;

import javafx.fxml.FXML;
import javafx.scene.text.Text;
import manager.AssoManager;
import persistence.Asso;

import java.sql.SQLException;

public class AssoIndexController extends ControllerAsso {

    @FXML
    public Text successMsg;
    @FXML
    public Text validationMsg;
    @FXML
    public Text ongoingProjects;



    @Override
    public void initData(Asso asso) {
        if( asso != null )
            this.asso = asso;
        else
            goToLandingPage();

        AssoManager assoManager = new AssoManager();
        if( asso != null && asso.getStatus() != 0 ){
            try {
                ongoingProjects.setText(String.valueOf(assoManager.getOngoingProject(asso.getId()).size()));
            }
             catch (SQLException e) {
                 e.printStackTrace();
             }
        }
        else
            ongoingProjects.setText("0");

        assert asso != null;
        if( asso.getStatus() == 0 )
            validationMsg.setText( "En attente de validation par un administrateur");
    }
}
