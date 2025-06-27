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

function TwoFactorChallenge() {
  const { trans } = useTranslationsStore();

  return (
    <div className="absolute top-1/2 left-1/2 grid -translate-x-1/2 -translate-y-1/2 transform gap-4">
      <Heading className="text-center" level="h1" variant="h4">
        {trans("auth.two_factor")}
      </Heading>
      <Card className="w-[18rem]">
        <CardContent>
          <FormProvider
            id="two-factor-challenge-form"
            render={() => (
              <Form
                className="grid gap-6"
                method="post"
                url={route("two-factor.login")}
              >
                <FormField
                  name="code"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="one-time-code"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="recovery_code"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel />
                      <Input
                        autoComplete="one-time-code"
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

export default TwoFactorChallenge;
