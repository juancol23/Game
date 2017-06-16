package game.valdcolra.com.game.view.mensages;

import android.util.Log;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

/**
 * Created by JuanValdemar on 16/06/2017.
 */

public class MiFirebaseInstanceIdService extends FirebaseInstanceIdService {

    //Este token nos dirá cuando cambien lso token
    //ahora que tenemos los servicios en manifest decirse a los se
    //servicios que los use

    public static final String TAG = "Mensajes";

    @Override
    public void onTokenRefresh() {
        super.onTokenRefresh();
        //que se ejecuta cuando nos asignan un token o cuando se actualiza
        String token = FirebaseInstanceId.getInstance().getToken();
        Log.d(TAG, "Token: " + token);
    }
}
