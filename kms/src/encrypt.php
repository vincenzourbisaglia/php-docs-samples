<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/kms/README.md
 */


// Include Google Cloud dependendencies using Composer
require_once __DIR__ . '/../vendor/autoload.php';

if (count($argv) != 7) {
    return printf("Usage: php %s PROJECT_ID LOCATION_ID KEYRING_ID CRYPTOKEY_ID PLAINTEXT_FILENAME CIPHERTEXT_FILENAME\n", basename(__FILE__));
}
list($_, $projectId, $locationId, $keyRingId, $cryptoKeyId, $plaintextFileName, $ciphertextFileName) = $argv;

# [START kms_encrypt]
use Google\Cloud\Kms\V1\KeyManagementServiceClient;

/** Uncomment and populate these variables in your code */
// $projectId = 'The Google project ID';
// $locationId = 'The location ID of the crypto key. Can be "global", "us-west1", etc.';
// $keyRingId = 'The KMS key ring ID';
// $cryptoKeyId = 'The KMS key ID';
// $plaintextFileName = 'The path to the file containing plaintext to encrypt';
// $ciphertextFileName = 'The path to write the ciphertext';

$kms = new KeyManagementServiceClient();

// The resource name of the CryptoKey.
$cryptoKeyName = $kms->cryptoKeyName($projectId, $locationId, $keyRingId, $cryptoKeyId);

$plaintext = file_get_contents($plaintextFileName);
$response = $kms->encrypt($cryptoKeyName, $plaintext);

// Write the encrypted text to a file.
file_put_contents($ciphertextFileName, $response->getCiphertext());
printf('Saved encrypted text to %s' . PHP_EOL, $ciphertextFileName);
# [END kms_encrypt]
