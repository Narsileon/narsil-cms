import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Head } from "@inertiajs/react";
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
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

type ResetPasswordProps = {
  token: string;
};

function ResetPassword({ token }: ResetPasswordProps) {
  const { trans } = useTranslationsStore();

  return (
    <>
      <Head title={trans("ui.reset_password", "Reset password")} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.reset_password", "Reset password")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="w-[18rem]">
              <CardContent>
                <FormProvider
                  id="reset-password-form"
                  initialData={{
                    email: "",
                    password_confirmation: "",
                    password: "",
                    token: token,
                  }}
                  render={() => (
                    <Form
                      className="grid gap-6"
                      method="post"
                      url={route("password.update")}
                    >
                      <FormField
                        name="email"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel required={true} />
                            <Input
                              autoComplete="email"
                              type="email"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        name="password"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel required={true} />
                            <Input
                              autoComplete="new-password"
                              type="password"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        name="password_confirmation"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel required={true} />
                            <Input
                              autoComplete="new-password"
                              type="password"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormSubmit>{trans("ui.reset", "Reset")}</FormSubmit>
                    </Form>
                  )}
                />
              </CardContent>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default ResetPassword;
