package controller.user;

import controller.ControllerOne;
import javafx.fxml.FXML;

import javafx.scene.text.Text;
import persistence.User;


public class UserIndexController extends ControllerOne {

    private User user = new User();

    @FXML
    private Text availableCoinsField;
    @FXML
    private Text usedCoins;

    public void initData(User user){
        this.user = user;

        if(user == null){
            goToUserConnexion();
        }
        else {
            availableCoinsField.setText(String.valueOf(user.getAvailableCoins()));
            usedCoins.setText(String.valueOf(user.getUsedCoins()));
        }

    }
}
