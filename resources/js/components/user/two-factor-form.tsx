import { Button } from "@narsil-cms/components/ui/button";
import { CopyIcon } from "lucide-react";
import { Label } from "@narsil-cms/components/ui/label";
import { route } from "ziggy-js";
import { router } from "@inertiajs/react";
import { Switch } from "@narsil-cms/components/ui/switch";
import { toast } from "sonner";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useState } from "react";
import axios from "axios";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/ui/card";
import {
  Form,
  FormFieldRenderer,
  FormProvider,
  FormSubmit,
} from "@narsil-cms/components/ui/form";
import type { FormType } from "@narsil-cms/types/forms";

type TwoFactorFormProps = {
  form: FormType;
};

function TwoFactorForm({ form }: TwoFactorFormProps) {
  const { getLabel } = useLabels();

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
          <Label>{getLabel("two-factor.two_factor_authentication")}</Label>
          <Switch checked={enabled} onCheckedChange={toggleEnabled} />
        </div>
        {!active && enabled && qrCode ? (
          <Card>
            <CardContent>
              <FormProvider
                id={form.id}
                fields={form.fields}
                render={({ setError }) => (
                  <Form
                    className="gap-6 md:grid-cols-2"
                    method={form.method}
                    url={form.url}
                    options={{
                      onSuccess: () => {
                        setActive(true);
                      },
                      onError() {
                        setError?.(
                          "code",
                          getLabel("validation.custom.code.invalid"),
                        );
                      },
                    }}
                  >
                    {form.fields.map((field, index) => (
                      <FormFieldRenderer field={field} key={index} />
                    ))}
                    <div
                      className="max-h-48 max-w-48 place-self-center [&>svg]:h-auto [&>svg]:w-full"
                      dangerouslySetInnerHTML={{
                        __html: qrCode,
                      }}
                    />
                    <FormSubmit>{form.submit}</FormSubmit>
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
                {getLabel("two-factor.recovery_codes_title")}
              </CardTitle>
              <Button
                className="place-self-end"
                variant="outline"
                size="icon"
                onClick={() => {
                  navigator.clipboard.writeText(recoveryCodes.join("\n"));

                  toast.success(getLabel("two-factor.recovery_codes_copied"));
                }}
              >
                <CopyIcon />
              </Button>
            </CardHeader>
            <CardContent className="grid gap-4 text-sm">
              <p>{getLabel("two-factor.recovery_codes_description")}</p>
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
