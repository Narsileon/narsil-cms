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
import UserConfirmPassword from "@/components/app/user/confirm-password";
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
  const [open, setOpen] = useState<boolean>(false);
  const [confirmed, setConfirmed] = useState<boolean>(false);
  const [enabled, setEnabled] = useState<boolean>(active);
  const [qrCode, setQrCode] = useState<string | null>(null);
  const [recoveryCodes, setRecoveryCodes] = useState<string[] | null>(null);

  async function getConfirmed(): Promise<boolean> {
    try {
      const response = await axios.get(route("password.confirmation"));

      setConfirmed(response.data.confirmed);

      return response.data.confirmed;
    } catch (error) {
      console.error("Error fetching password confirmation:", error);

      return false;
    }
  }

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

  function onConfirmed() {
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

  async function toggleEnabled() {
    await getConfirmed();

    if (!confirmed) {
      setOpen(true);
    } else {
      onConfirmed();
    }
  }

  return (
    <>
      <div className="grid gap-4">
        <div className="flex h-9 items-center justify-between">
          <Label>{trans("auth.two_factor")}</Label>
          <Switch checked={enabled} onCheckedChange={toggleEnabled} />
        </div>
        {!active && enabled && qrCode ? (
          <Card>
            <CardContent>
              <FormProvider
                id="user-two-factor-form"
                render={({ setError }) => (
                  <Form
                    className="grid gap-4"
                    url={route("two-factor.confirm")}
                    options={{
                      onSuccess: () => {
                        console.log("hallo");
                        setActive(true);
                      },
                      onError() {
                        setError?.(
                          "code",
                          trans("validation.custom.code.invalid"),
                        );
                      },
                    }}
                  >
                    <p>{trans("auth.two_factor_description")}</p>
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
                    <FormSubmit>{trans("ui.confirm")}</FormSubmit>
                  </Form>
                )}
              />
            </CardContent>
          </Card>
        ) : null}
        {!active && enabled && recoveryCodes ? (
          <Card>
            <CardHeader className="grid-cols-2 items-center border-b">
              <CardTitle>{trans("auth.recovery_codes")}</CardTitle>
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
              <p>{trans("auth.recovery_codes_description")}</p>

              <ul className="ml-6 list-disc">
                {recoveryCodes?.map((recoveryCode, index) => {
                  return <li key={index}>{recoveryCode}</li>;
                })}
              </ul>
            </CardContent>
          </Card>
        ) : null}
      </div>
      <UserConfirmPassword
        open={open}
        onConfirmed={onConfirmed}
        onOpenChange={setOpen}
      />
    </>
  );
}

export default UserSettingsSecurityTwoFactor;
