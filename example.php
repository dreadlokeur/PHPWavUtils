<?php

require_once 'WavFile.php';
require_once 'WavMaker.php';

siusecase();
//maryHad();
//noiseTest();
//sineTest();
//squareTest();
//sineWave();
mergeWavs();

function siusecase()
{
	$audio_path = dirname(__FILE__) . '/audio';
	
	$wav = new WavMaker(1, 11025, 16);
	
	$letters = array('p', 'k', 'l', '2', '5', 'm');
	$wavs    = array();
	foreach ($letters as $letter) {
		$letter = strtoupper($letter);
		
		if (!isset($wavs[$letter])) {
			try {
				$l = new WavFile($audio_path . '/' . $letter . '.wav');
				$wavs[$letter] = $l;
			} catch (Exception $ex) {
				// 	failed to open file...handle
				die("Error with character '$letter': " . $ex->getMessage());
			}
		}

		$wav->appendWav($wavs[$letter]);
	}
	
	$wav->save(dirname(__FILE__) . '/wavs/siout.wav');
		
	$sound = new WavFile(dirname(__FILE__) . '/wavs/mary.wav');
	
	$wav->mergeWav($sound);
	
	$wav->save(dirname(__FILE__) . '/wavs/siout-merged.wav');
	
	die('Saved captcha');
}

function mergeWavs()
{
    $wav1 = new WavFile(dirname(__FILE__) . '/wavs/spin.wav');
    $wav2 = new WavFile(dirname(__FILE__) . '/wavs/sinetest-2-44100-8.wav');
    
    $wav1->mergeWav($wav2);
    
    $fp = fopen(dirname(__FILE__) . '/wavs/merged.wav', 'w+b');
    fwrite($fp, $wav1->makeHeader());
    fwrite($fp, $wav1->getDataSubchunk());
    
    fclose($fp);
    
    die('Merge completed');
}

function maryHad()
{
    $wav = new WavMaker(1, 11025, 16);
    
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSineWav(391.995, 0.4); // g
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(493.883, 0.8); // b
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSilence(0.05);
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSilence(0.05);
    $wav->generateSineWav(440, 0.8);     // a
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(587.330, 0.4); // d
    $wav->generateSineWav(587.330);      // d
    $wav->generateSilence(2); // long pause
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSineWav(391.995, 0.4); // g
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(493.883, 0.8); // b
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSilence(0.05);
    $wav->generateSineWav(440, 0.4);     // a
    $wav->generateSilence(0.05);
    $wav->generateSineWav(440, 0.8);     // a
    $wav->generateSineWav(493.883, 0.4); // b
    $wav->generateSineWav(587.330, 0.4); // d
    $wav->generateSineWav(587.330);      // d
    
    $wav->save(dirname(__FILE__) . '/wavs/mary.wav');
    
    die('Mary had a little lamb');
}

function sineTest()
{
    // generate 3 second sine waves in multiple bit and sample rates
    $sps = array(8000, 11025, 22050, 44100);
    $bps = array(8, 16, 24);
    
    foreach($sps as $samplesPerSec) {
        foreach($bps as $bitsPerSample) {
            $wav = new WavMaker(2, $samplesPerSec, $bitsPerSample);
            $wav->generateSineWav(329.628, 3);
            
            $wav->save(dirname(__FILE__) . '/wavs/sinetest-2-' . $samplesPerSec . '-' . $bitsPerSample . '.wav');
        }
    }
    
    die('Sine test completed');
}

function squareTest()
{
    $sps = array(8000, 11025, 22050, 44100);
    $bps = array(8, 16, 24);
    
    foreach($sps as $samplesPerSec) {
        foreach($bps as $bitsPerSample) {
            $wav = new WavMaker(1, $samplesPerSec, $bitsPerSample);
            $wav->generateSquareWave(130.813, 3);
            
            $wav->save(dirname(__FILE__) . '/wavs/squaretest-1-' . $samplesPerSec . '-' . $bitsPerSample . '.wav');
        }
    }
    
    die('Square test completed');
}

function noiseTest()
{
    $sps = array(8000, 44100);
    $bps = array(8, 16);
    
    foreach($sps as $samplesPerSec) {
        foreach($bps as $bitsPerSample) {
            $wav = new WavMaker(1, $samplesPerSec, $bitsPerSample);
            $wav->generateNoise(3);
            
            $wav->save(dirname(__FILE__) . '/wavs/noise-1-' . $samplesPerSec . '-' . $bitsPerSample . '.wav');
        }
    }
    
    die('Noise test completed');
}

function sineWave()
{
    $wav = new WavMaker(1, 44100, 16); // 2 channel, 44100 samples/sec, 16 bits/sample
    $wav->generateSineWav(659.255, 3); // E5 for 2 seconds
    
    
    $fp = fopen(dirname(__FILE__) . '/wavs/sine.wav', 'w+b');
    fwrite($fp, $wav->makeHeader());
    fwrite($fp, $wav->getDataSubchunk());
    
    fclose($fp);
    
    die('Sine wav completed');
}
