package game.valdcolra.com.game.view.splash;

import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import com.google.android.gms.ads.AdListener;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.InterstitialAd;

import game.valdcolra.com.game.R;
import game.valdcolra.com.game.view.menu.Menu;

public class Splash extends AppCompatActivity {
    InterstitialAd mInterstitialAd;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);

        mInterstitialAd = new InterstitialAd(this);
        mInterstitialAd.setAdUnitId("ca-app-pub-3940256099942544/1033173712");

        mInterstitialAd.setAdListener(new AdListener() {
            @Override
            public void onAdClosed() {
                requestNewInterstitial();
            }
        });

        requestNewInterstitial();

        if (mInterstitialAd.isLoaded()) {
            mInterstitialAd.show();
        } else {
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                   /* startActivity(new Intent(Splash.this, Main_Activity_Fragment.class));*/
                    startActivity(new Intent(Splash.this, Menu.class));
                    finish();
                }
            }, 2000);
        }

    }

    private void requestNewInterstitial() {
        AdRequest adRequest = new AdRequest.Builder()
                .build();

        mInterstitialAd.loadAd(adRequest);
    }
}
