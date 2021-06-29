package controller.admin;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.text.Text;
import javafx.scene.text.TextAlignment;
import manager.AssoManager;
import persistence.Asso;
import persistence.User;

import java.sql.SQLException;

public class AdminAssoController extends ControllerAdmin{

    public Asso asso;

    @FXML private Text title;
    @FXML private Text numeroRNA;
    @FXML private Text signUpDate;
    @FXML private Text email;
    @FXML private Text description;

    public void initData(Asso asso, User user) {

        if (asso == null)
            goToLandingPage();
        else
            this.asso = asso;

        if (user != null)
            this.admin = user;
        else
            goToLandingPage();

        if (admin.getRoles() == 0)
            goToLandingPage();

        assert asso != null;
        title.setText(asso.getName());
        title.setTextAlignment(TextAlignment.CENTER);
        numeroRNA.setText(asso.getNumeroRNA());
        signUpDate.setText(asso.getSignupDate().toLocalDate().toString());
        email.setText(asso.getEmail());
        description.setText(asso.getDescription());
    }

    @FXML
    public void validateAsso(ActionEvent event){
        AssoManager assoManager = new AssoManager();
        try {
            assoManager.updateStatus(asso.getId());
            ControllerOne.loadAdminIndex(event, admin);
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }

    }

    @FXML
    public void supprAsso(ActionEvent event){
        AssoManager assoManager = new AssoManager();
        try {
            assoManager.deleteAsso(asso.getId());
            ControllerOne.loadAdminIndex(event, admin);
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }

    }

    @FXML
    public void goBack(ActionEvent event){
        ControllerOne.loadAdminIndex(event, admin);
    }
}
