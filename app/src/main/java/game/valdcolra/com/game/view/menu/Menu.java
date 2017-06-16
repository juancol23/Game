package game.valdcolra.com.game.view.menu;


import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.Toast;


import com.google.android.gms.ads.AdListener;
import com.google.android.gms.ads.AdRequest;

import com.google.android.gms.ads.AdView;
import com.google.android.gms.ads.InterstitialAd;

import com.google.android.gms.ads.reward.RewardedVideoAd;


import game.valdcolra.com.game.R;
import game.valdcolra.com.game.view.categoria.InicioGamePlataforma;

public class Menu extends AppCompatActivity {


    FrameLayout framePlataforma,
            framebtnCarrera,
            framebtnArcade;

    InterstitialAd mInterstitialAd;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);
        /*Video Remunerado*/


        /*Banner*/
        AdView mAdView = (AdView) findViewById(R.id.adView);
        AdRequest adRequest = new AdRequest.Builder().build();
        mAdView.loadAd(adRequest);


        /*Interstitial*/
        mInterstitialAd = new InterstitialAd(this);
        mInterstitialAd.setAdUnitId("ca-app-pub-3969015674796521~9918797496");

        mInterstitialAd.setAdListener(new AdListener() {
            @Override
            public void onAdClosed() {
                requestNewInterstitial();

            }
        });

        requestNewInterstitial();

        framePlataforma = (FrameLayout) findViewById(R.id.framePlataforma);
        framebtnCarrera = (FrameLayout) findViewById(R.id.frameCarrera);
        framebtnArcade = (FrameLayout) findViewById(R.id.frameArcade);


        framePlataforma.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (mInterstitialAd.isLoaded()) {
                    mInterstitialAd.show();
                } else {
                    irIniciar();
                }
            }
        });

        framebtnCarrera.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (mInterstitialAd.isLoaded()) {
                    mInterstitialAd.show();
                } else {
                    irIntrucciones();
                }
            }
        });

        framebtnArcade.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (mInterstitialAd.isLoaded()) {
                    mInterstitialAd.show();
                } else {
                    irIntrucciones();
                }
            }
        });
    }


    private void requestNewInterstitial() {
        AdRequest adRequest = new AdRequest.Builder()
                .build();

        mInterstitialAd.loadAd(adRequest);
    }

    private void irIniciar() {
           startActivity(new Intent(Menu.this, InicioGamePlataforma.class));
    }

    private void irIntrucciones() {
        // startActivity(new Intent(Menu.this, InicioGamePlataforma.class));

    }

    private void irAgradecimiento() {
        //  startActivity(new Intent(Menu.this, InicioGameAventura.class));
    }

    private void Mensaje(String Mensaje) {
        Toast.makeText(Menu.this, Mensaje, Toast.LENGTH_SHORT).show();
    }


}