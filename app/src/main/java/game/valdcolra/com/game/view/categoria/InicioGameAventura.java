package game.valdcolra.com.game.view.categoria;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import game.valdcolra.com.game.R;

public class InicioGameAventura extends AppCompatActivity {
    WebView webViewUno;
    SwipeRefreshLayout swipeRefreshLayout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio_game_aventura);
        webViewUno = (WebView) findViewById(R.id.webViewUno);
        swipeRefreshLayout = (SwipeRefreshLayout)findViewById(R.id.swiperefresh);

        webViewUno.getSettings().setJavaScriptEnabled(true);
        webViewUno.setWebViewClient(new WebViewClient());


        if (isOnline(getApplicationContext())) {
            webViewUno.loadUrl("http://192.168.0.100/w/");
            // Toast.makeText(getApplicationContext(), "si internet no archivo",Toast.LENGTH_SHORT).show();
        } else {
            webViewUno.loadUrl("file:///android_asset/www/404.html");
        }


        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                if (isOnline(getApplicationContext())) {
                    webViewUno.loadUrl("http://192.168.0.100/w/");
                    // Toast.makeText(getApplicationContext(), "si internet no archivo",Toast.LENGTH_SHORT).show();
                } else {
                    webViewUno.loadUrl("file:///android_asset/www/404.html");
                }
            }

        });

        webViewUno.setWebViewClient(new WebViewClient() {
            @Override
            public void onPageFinished(WebView v, String url) {
                swipeRefreshLayout.setRefreshing(false);
            }
        });

    }

    public static boolean isOnline(Context context) {
        ConnectivityManager connectivityManager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();
        return networkInfo != null && networkInfo.isAvailable() && networkInfo.isConnected();
    }
}