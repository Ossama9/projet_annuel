package controller.project;

import controller.ControllerOne;
import controller.user.ControllerUser;
import javafx.beans.value.ObservableValue;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.Slider;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.Pane;
import javafx.scene.layout.StackPane;
import javafx.scene.layout.VBox;
import javafx.scene.text.Text;
import javafx.scene.text.TextAlignment;
import javafx.stage.Popup;
import javafx.stage.Stage;
import manager.CoinsManager;
import persistence.Asso;
import persistence.Project;
import persistence.User;

import java.sql.SQLException;

public class ProjectIndexController extends ControllerOne {

    @FXML private Text earnedCoins;
    @FXML private Text title;
    @FXML private Text successMsg;
    @FXML private Text depositDate;
    @FXML private Text associationName;
    @FXML private Text startDate;
    @FXML private Text endDate;
    @FXML private Text description;
    @FXML private Pane connection;
    @FXML private Button supprBtn;
    @FXML private Button payBtn;
    @FXML private Button deconexion;

    public Project project;
    public User user;
    public Asso asso;

    public void initData(Project project){
        if( project == null )
            goToLandingPage();

        connection.setVisible(true);
        payBtn.setVisible(false);
        deconexion.setVisible(false);

        if( asso != null ){
            supprBtn.setVisible(true);
            //this.asso = asso;
        }

        this.project = project;


        earnedCoins.setText(String.valueOf(project.getCoinsEarned()));

        title.setText(project.getName());
        title.setTextAlignment(TextAlignment.CENTER);

        depositDate.setText(project.getDepositDate().toLocalDate().toString());
        associationName.setText(project.getAssoName());
        startDate.setText(project.getStartDate().toLocalDate().toString());
        endDate.setText(project.getEndDate().toLocalDate().toString());
        description.setText(project.getDescription());
    }

    public void initData(Project project, User user){
        if( project == null )
            goToLandingPage();

        if( user != null )
            this.user = user;
        else
            connection.setVisible(true);

        this.project = project;

        earnedCoins.setText(String.valueOf(project.getCoinsEarned()));

        title.setText(project.getName());
        title.setTextAlignment(TextAlignment.CENTER);

        depositDate.setText(project.getDepositDate().toLocalDate().toString());
        associationName.setText(project.getAssoName());
        startDate.setText(project.getStartDate().toLocalDate().toString());
        endDate.setText(project.getEndDate().toLocalDate().toString());
        description.setText(project.getDescription());
    }


    @FXML
    public void createPopup(ActionEvent event){

        Popup popup = new Popup();

        Label label = new Label("Choisissez le montant de votre dont");
        label.setTextAlignment(TextAlignment.CENTER);
        label.setLayoutY(10);
        Slider slider = new Slider(0, user.getAvailableCoins(), (double)user.getAvailableCoins()/2);
        slider.setShowTickLabels(true);
        slider.setLayoutY(50);

        Button validate = new Button("Valider");
        validate.setStyle("-fx-background-color: #08f008");
        validate.setAlignment(Pos.BOTTOM_LEFT);

        EventHandler<ActionEvent> eventValidate =
                e -> donate((int)slider.getValue());

        validate.setOnAction(eventValidate);

        Button cancel = new Button("Annuler");
        cancel.setStyle("-fx-background-color: #ff0000");
        cancel.setAlignment(Pos.BOTTOM_RIGHT);

        EventHandler<ActionEvent> eventCancel =
                e -> popup.hide();

        cancel.setOnAction(eventCancel);


        VBox root = new VBox();
        root.setPadding(new Insets(20));
        root.setSpacing(10);
        root.setStyle("-fx-background-color: #ffffff");
        root.setAlignment(Pos.CENTER);
        root.getChildren().addAll(label, slider, validate, cancel);

        popup.getContent().add(root);
        popup.show(mainPane.getScene().getWindow());

    }


    @FXML
    public void goBack(ActionEvent event){
        ControllerOne.loadUserIndex(event, user);
    }


    public void donate(int amount){
        System.out.println("donate1 : "+amount+"  "+user.getId()+"  "+project.getId());
        CoinsManager coinsManager = new CoinsManager();

        try {
            if (coinsManager.allreadyDonate(user.getId(), project.getId()) != 0) {
                System.out.println("donate2");
                coinsManager.updateDonation(user.getId(), project.getId(), amount);
            }
            else {
                System.out.println("donate3");
                coinsManager.createDonation(user.getId(), project.getId(), amount);
                successMsg.setText("Votre dons à bien été pris en compte !");
                successMsg.setTextAlignment(TextAlignment.CENTER);
                int tmp = Integer.parseInt(earnedCoins.getText())+amount;
                earnedCoins.setText(String.valueOf(tmp));
            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }
}
