package controller.user;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;

import javafx.scene.text.Text;
import javafx.stage.Stage;
import persistence.User;

import java.io.IOException;
import java.util.Objects;

public class UserIndexController{

    private User user = new User();

    @FXML
    private Text availableCoinsField;
    @FXML
    private Text usedCoins;

    public void initData(User user){
        this.user = user;

        availableCoinsField.setText(String.valueOf(user.getAvailableCoins()));
        usedCoins.setText(String.valueOf(user.getUsedCoins()));
    }


    @FXML
    public void signOut(ActionEvent event){
        try {
            Parent root = FXMLLoader.load(Objects.requireNonNull(getClass().getResource("/gui/landing_page.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(root);
            currentStage.setScene(scene);
            currentStage.setTitle("Accueil");
            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }
}
