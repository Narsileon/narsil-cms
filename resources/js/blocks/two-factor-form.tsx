import { router } from "@inertiajs/react";
import axios from "axios";
import { useState } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { Button } from "@narsil-cms/components/button";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/card";
import {
  FormFieldRenderer,
  FormProvider,
  FormRoot,
  FormSubmit,
} from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { LabelRoot } from "@narsil-cms/components/label";
import { useLabels } from "@narsil-cms/components/labels";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { type FormType } from "@narsil-cms/types";

import Switch from "./switch";

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
          <LabelRoot>{trans("two-factor.two_factor_authentication")}</LabelRoot>
          <Switch checked={enabled} onCheckedChange={toggleEnabled} />
        </div>
        {!active && enabled && qrCode ? (
          <FormProvider
            action={form.action}
            id={form.id}
            elements={form.form}
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
                <Card>
                  <CardContent className="grid-cols-12">
                    {form.form.map((element, index) => (
                      <FormFieldRenderer element={element} key={index} />
                    ))}
                    <div
                      className="col-span-full max-h-48 max-w-48 place-self-center [&>svg]:h-auto [&>svg]:w-full"
                      dangerouslySetInnerHTML={{
                        __html: qrCode,
                      }}
                    />
                  </CardContent>
                  <CardFooter className="justify-end border-t">
                    <FormSubmit>{form.submitLabel}</FormSubmit>
                  </CardFooter>
                </Card>
              </FormRoot>
            )}
          />
        ) : null}
        {!active && enabled && recoveryCodes ? (
          <Card>
            <CardHeader className="grid-cols-2 items-center border-b">
              <CardTitle>{trans("two-factor.recovery_codes_title")}</CardTitle>
              <Button
                className="place-self-end"
                variant="outline"
                size="icon"
                onClick={() => {
                  navigator.clipboard.writeText(recoveryCodes.join("\n"));

                  toast.success(trans("two-factor.recovery_codes_copied"));
                }}
              >
                <Icon name="copy" />
              </Button>
            </CardHeader>
            <CardContent className="gap-4 text-sm">
              <p>{trans("two-factor.recovery_codes_description")}</p>
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

export default TwoFactorForm;
