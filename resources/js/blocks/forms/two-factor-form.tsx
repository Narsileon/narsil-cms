import { router } from "@inertiajs/react";
import { Switch } from "@narsil-cms/blocks/fields/switch";
import { Icon } from "@narsil-cms/blocks/icon";
import { Button } from "@narsil-cms/components/button";
import {
  CardContent,
  CardFooter,
  CardHeader,
  CardRoot,
  CardTitle,
} from "@narsil-cms/components/card";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import { Label } from "@narsil-cms/components/label";
import { useLocalization } from "@narsil-cms/components/localization";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { useAuth } from "@narsil-cms/hooks/use-props";
import type { FormType } from "@narsil-cms/types";
import { Fragment, useState } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

type TwoFactorFormProps = {
  form: FormType;
};

function TwoFactorForm({ form }: TwoFactorFormProps) {
  const { trans } = useLocalization();

  const { two_factor_confirmed_at } = useAuth() ?? {};

  const [active, setActive] = useState(two_factor_confirmed_at !== null);
  const [enabled, setEnabled] = useState(active);
  const [qrCode, setQrCode] = useState<string | null>(null);
  const [recoveryCodes, setRecoveryCodes] = useState<string[] | null>(null);

  async function getQrCode(): Promise<void> {
    try {
      const response = await fetch(route("two-factor.qr-code"));

      const data = await response.json();

      setQrCode(data.svg);
    } catch (error) {
      console.error("[Two Factor] Error fetching QR code:", error);
    }
  }

  async function getRecoveryCodes(): Promise<void> {
    try {
      const response = await fetch(route("two-factor.recovery-codes"));

      const data = await response.json();

      setRecoveryCodes(data);
    } catch (error) {
      console.error("[Two Factor] Error fetching recovery codes:", error);
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
          <Label>{trans("two-factor.two_factor_authentication")}</Label>
          <Switch checked={enabled} onCheckedChange={toggleEnabled} />
        </div>
        {!active && enabled && qrCode ? (
          <FormProvider
            action={form.action}
            id={form.id}
            elements={form.tabs}
            method={form.method}
            render={({ setError }) => {
              return (
                <FormRoot
                  options={{
                    onSuccess: () => {
                      setActive(true);
                    },
                    onError() {
                      setError?.("code", trans("validation.custom.code.invalid"));
                    },
                  }}
                >
                  <CardRoot>
                    <CardContent className="grid-cols-12">
                      {form.tabs.map((tab, index) => {
                        return (
                          <Fragment key={index}>
                            {tab.elements?.map((element, index) => {
                              return <FormElement {...element} key={index} />;
                            })}
                          </Fragment>
                        );
                      })}
                      <div
                        className="col-span-full max-h-48 max-w-48 place-self-center [&>svg]:h-auto [&>svg]:w-full"
                        dangerouslySetInnerHTML={{
                          __html: qrCode,
                        }}
                      />
                    </CardContent>
                    <CardFooter className="justify-end border-t">
                      <Button form={form.id} type="submit">
                        {form.submitLabel}
                      </Button>
                    </CardFooter>
                  </CardRoot>
                </FormRoot>
              );
            }}
          />
        ) : null}
        {!active && enabled && recoveryCodes ? (
          <CardRoot>
            <CardHeader className="grid-cols-2 items-center border-b">
              <CardTitle>{trans("two-factor.recovery_codes_title")}</CardTitle>
              <Tooltip tooltip={trans("ui.copy_clipboard")}>
                <Button
                  aria-label={trans("ui.copy_clipboard")}
                  className="place-self-end"
                  size="icon"
                  variant="outline"
                  onClick={() => {
                    navigator.clipboard.writeText(recoveryCodes.join("\n"));

                    toast.success(trans("two-factor.recovery_codes_copied"));
                  }}
                >
                  <Icon name="copy" />
                </Button>
              </Tooltip>
            </CardHeader>
            <CardContent className="gap-4">
              <p>{trans("two-factor.recovery_codes_description")}</p>
              <ul className="ml-6 list-disc">
                {recoveryCodes?.map((recoveryCode, index) => {
                  return <li key={index}>{recoveryCode}</li>;
                })}
              </ul>
            </CardContent>
          </CardRoot>
        ) : null}
      </div>
    </>
  );
}

export default TwoFactorForm;
