import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { CopyIcon } from "lucide-react";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { route } from "ziggy-js";
import { router, usePage } from "@inertiajs/react";
import { Switch } from "@/components/ui/switch";
import { useState } from "react";
import axios from "axios";
import useTranslationsStore from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@/components/ui/form";
import type { GlobalProps } from "@/types/global";

function UserSettingsSecurityTwoFactor() {
  const { two_factor_confirmed_at } = usePage<GlobalProps>().props.auth;

  const { trans } = useTranslationsStore();

  const [active, setActive] = useState<boolean>(
    two_factor_confirmed_at !== null,
  );
  const [enabled, setEnabled] = useState<boolean>(active);
  const [qrCode, setQrCode] = useState<string | null>(null);
  const [recoveryCodes, setRecoveryCodes] = useState<string[] | null>(null);

  async function getQrCode(): Promise<void> {
    try {
      const response = await axios.get(route("two-factor.qr-code"));

      setQrCode(response.data.svg);
    } catch (error) {
      console.error("Error fetching two factor QR code:", error);
    }
  }

  async function getRecoveryCodes(): Promise<void> {
    try {
      const response = await axios.get(route("two-factor.recovery-codes"));

      setRecoveryCodes(response.data);
    } catch (error) {
      console.error("Error fetching two factor recovery codes:", error);
    }
  }

  async function toggleEnabled() {
    if (enabled) {
      router.delete(route("two-factor.disable"), {
        preserveState: true,
        onSuccess: () => {
          setActive(false);
          setEnabled(false);
        },
        onError: () => {
          setEnabled(true);
        },
      });
    } else {
      router.post(route("two-factor.enable"), undefined, {
        onSuccess: async () => {
          await getQrCode();
          await getRecoveryCodes();

          setEnabled(true);
        },

        onError: () => {
          setEnabled(false);
        },
      });
    }
  }

  return (
    <>
      <div className="grid gap-4">
        <div className="flex items-center justify-between">
          <Label>
            {trans("ui.two_factor_authentication", "Two-factor authentication")}
          </Label>
          <Switch checked={enabled} onCheckedChange={toggleEnabled} />
        </div>
        {!active && enabled && qrCode ? (
          <Card>
            <CardContent>
              <FormProvider
                id="user-two-factor-form"
                initialData={{
                  code: "",
                }}
                render={({ setError }) => (
                  <Form
                    className="grid gap-4"
                    url={route("two-factor.confirm")}
                    options={{
                      onSuccess: () => {
                        setActive(true);
                      },
                      onError() {
                        setError?.(
                          "code",
                          trans(
                            "validation.custom.code.invalid",
                            "The code is invalid.",
                          ),
                        );
                      },
                    }}
                  >
                    <p>
                      {trans(
                        "two-factor.description",
                        "Please scan the following QR code using your phone's authenticator application and enter your code.",
                      )}
                    </p>
                    <div
                      className="[&>svg]:h-auto [&>svg]:w-full"
                      dangerouslySetInnerHTML={{
                        __html: qrCode,
                      }}
                    />
                    <FormField
                      name="code"
                      render={({ onChange, ...field }) => (
                        <FormItem>
                          <div className="flex items-center justify-between gap-4">
                            <FormLabel required={true} />
                            <Input
                              autoComplete="one-time-code"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                          </div>

                          <FormMessage />
                        </FormItem>
                      )}
                    />
                    <FormSubmit>{trans("ui.confirm", "Confirm")}</FormSubmit>
                  </Form>
                )}
              />
            </CardContent>
          </Card>
        ) : null}
        {!active && enabled && recoveryCodes ? (
          <Card>
            <CardHeader className="grid-cols-2 items-center border-b">
              <CardTitle>
                {trans("ui.recovery_codes", "Recovery codes")}
              </CardTitle>
              <Button
                className="place-self-end"
                size="icon"
                onClick={() => {
                  navigator.clipboard.writeText(recoveryCodes.join("\n"));
                }}
              >
                <CopyIcon />
              </Button>
            </CardHeader>
            <CardContent className="grid gap-4">
              <p>
                {trans(
                  "two-factor.prompt",
                  "Store these recovery codes in a safe place. You can use them to access your account if your two-factor authentication device is lost.",
                )}
              </p>
              <ul className="ml-6 list-disc">
                {recoveryCodes?.map((recoveryCode, index) => {
                  return <li key={index}>{recoveryCode}</li>;
                })}
              </ul>
            </CardContent>
          </Card>
        ) : null}
      </div>
    </>
  );
}

export default UserSettingsSecurityTwoFactor;
