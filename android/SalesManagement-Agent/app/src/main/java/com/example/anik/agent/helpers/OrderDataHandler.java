package com.example.anik.agent.helpers;

import android.content.Context;

/**
 * Created by Anik on 17-Aug-15, 017.
 */
public class OrderDataHandler implements Runnable {

    private Context context;

    public OrderDataHandler(Context context) {
        this.context = context;
    }

    @Override
    public void run() {
        while (true) {
            synchronized (this) {
                try {
                    Thread.sleep(1 * AppConstant.TIME_MINUTES);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                AppHelper.sendBroadcast(AppConstant.BROADCAST_ORDER);
            }
        }
    }
}
