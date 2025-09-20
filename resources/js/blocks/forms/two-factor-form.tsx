import { router } from "@inertiajs/react";
import { useState } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { Card, Label, Switch } from "@narsil-cms/blocks";
import {
  FormRenderer,
  FormProvider,
  FormRoot,
} from "@narsil-cms/components/form";
import { useLabels } from "@narsil-cms/components/labels";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { type FormType } from "@narsil-cms/types";

type TwoFactorFormProps = {
  form: FormType;
};

function TwoFactorForm({ form }: TwoFactorFormProps) {
  const { trans } = useLabels();

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
            elements={form.layout}
            method={form.method}
            render={({ setError }) => (
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
                <Card
                  contentProps={{ className: "grid-cols-12" }}
                  footerButtons={[
                    {
                      form: form.id,
                      label: form.submitLabel,
                      type: "submit",
                    },
                  ]}
                  footerProps={{ className: "justify-end border-t" }}
                >
                  {form.layout.map((element, index) => (
                    <FormRenderer {...element} key={index} />
                  ))}
                  <div
                    className="col-span-full max-h-48 max-w-48 place-self-center [&>svg]:h-auto [&>svg]:w-full"
                    dangerouslySetInnerHTML={{
                      __html: qrCode,
                    }}
                  />
                </Card>
              </FormRoot>
            )}
          />
        ) : null}
        {!active && enabled && recoveryCodes ? (
          <Card
            contentProps={{ className: "gap-4" }}
            headerButtons={[
              {
                className: "place-self-end",
                iconProps: {
                  name: "copy",
                },
                size: "icon",
                tooltip: trans("ui.copy_clipboard"),
                variant: "outline",
                onClick: () => {
                  navigator.clipboard.writeText(recoveryCodes.join("\n"));

                  toast.success(trans("two-factor.recovery_codes_copied"));
                },
              },
            ]}
            headerProps={{ className: "grid-cols-2 items-center border-b" }}
            title={trans("two-factor.recovery_codes_title")}
          >
            <p>{trans("two-factor.recovery_codes_description")}</p>
            <ul className="ml-6 list-disc">
              {recoveryCodes?.map((recoveryCode, index) => {
                return <li key={index}>{recoveryCode}</li>;
              })}
            </ul>
          </Card>
        ) : null}
      </div>
    </>
  );
}

export default TwoFactorForm;
