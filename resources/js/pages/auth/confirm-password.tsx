import { Card, CardContent } from "@/components/ui/card";
import { Heading } from "@/components/ui/heading";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
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

function ConfirmPassword() {
  const { trans } = useTranslationsStore();

  return (
    <div className="absolute top-1/2 left-1/2 grid -translate-x-1/2 -translate-y-1/2 transform gap-4">
      <Heading className="text-center" level="h1" variant="h4">
        {trans("passwords.confirming")}
      </Heading>
      <Card className="w-[18rem]">
        <CardContent>
          <FormProvider
            id="confirm-password-form"
            render={() => (
              <Form
                className="grid gap-6"
                method="post"
                url={route("password.confirm")}
              >
                <FormField
                  name="password"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="one-time-code"
                        type="password"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
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
    </div>
  );
}

export default ConfirmPassword;
