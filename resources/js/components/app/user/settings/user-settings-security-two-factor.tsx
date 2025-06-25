import { Label } from "@/components/ui/label";
import { route } from "ziggy-js";
import { router } from "@inertiajs/react";
import { Switch } from "@/components/ui/switch";
import { useState } from "react";
import { useTranslationsStore } from "@/stores/translations-store";
import axios from "axios";
import { Card, CardHeader, CardTitle } from "@/components/ui/card";

function UserSettingsSecurityTwoFactor() {
  const { trans } = useTranslationsStore();

  const [confirmed, setConfirmed] = useState<boolean>(false);
  const [enabled, setEnabled] = useState<boolean>(false);
  const [qrCode, setQrCode] = useState<string | null>(null);
  const [recoveryCodes, setRecoveryCodes] = useState<string[] | null>(null);

  async function getConfirmed() {
    try {
      const response = await axios.get(route("password.confirmation"));

      setConfirmed(response.data.confirmed);
    } catch (error) {
      console.error("Error fetching password confirmation:", error);
    }
  }

  async function getQrCode() {
    try {
      const response = await axios.get(route("two-factor.qr-code"));

      setQrCode(response.data.svg);
    } catch (error) {
      console.error("Error fetching two factor QR code:", error);
    }
  }

  async function getRecoveryCodes() {
    try {
      const response = await axios.get(route("two-factor.recovery-codes"));

      setRecoveryCodes(response.data);
    } catch (error) {
      console.error("Error fetching two factor recovery codes:", error);
    }
  }

  function toggleEnabled(enabled: boolean) {
    if (enabled) {
      router.post(route("two-factor.enable"), undefined, {
        preserveScroll: true,
        onSuccess: async () => {
          await getQrCode();
          await getRecoveryCodes();

          setEnabled(true);
        },
        onError: () => {
          setEnabled(false);
        },
      });
    } else {
      router.delete(route("two-factor.disable"), {
        preserveScroll: true,
        onSuccess: () => {
          setEnabled(false);
        },
        onError: () => {
          setEnabled(true);
        },
      });
    }
  }

  return (
    <div className="flex h-9 items-center justify-between">
      <Label>{trans("Enable Two-Factor Authentication")}</Label>
      <Switch checked={enabled} onCheckedChange={toggleEnabled} />
      {/* {qrCode ? (
        <Card>
          <CardHeader>
            <CardTitle>{trans("common.confirmation")}</CardTitle>
          </CardHeader>
          <CardContent>
            <FormProvider {...reactForm}>
              <Form route={route("two-factor.confirm")}>
                <p>
                  {trans(
                    "Please scan the following QR code using your phone's authenticator application and enter your code.",
                  )}
                </p>

                <div>{parse(qrCode)}</div>

                <FormRenderer nodes={form.nodes} />
              </Form>
            </FormProvider>
          </CardContent>
          <CardFooter>
            <Button>{trans("verbs.confirm")}</Button>
          </CardFooter>
        </Card>
      ) : null}
      {recoveryCodes ? (
        <Card>
          <CardHeader>
            <CardTitle>{trans("common.recovery_codes")}</CardTitle>
          </CardHeader>
          <CardContent>
            <p>{trans("Please find below your emergency recovery codes:")}</p>

            <ul className="ml-8 list-disc">
              {recoveryCodes?.map((recoveryCode, index) => {
                return <li key={index}>{recoveryCode}</li>;
              })}
            </ul>

            <p>
              {trans(
                "They can be used to recover access to your account if the two-factor authentication cannot be completed.",
              )}
            </p>
          </CardContent>
        </Card>
      ) : null} */}
    </div>
  );
}

export default UserSettingsSecurityTwoFactor;
