import { Card, CardContent } from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import { Container } from "@/components/ui/container";
import { Input } from "@/components/ui/input";
import { Head, Link } from "@inertiajs/react";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
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

type LoginProps = {
  status?: string;
};

function Login({ status }: LoginProps) {
  const { trans } = useTranslationsStore();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={trans("ui.connection", "Connection")} />
      <Container
        className="flex flex-col items-center justify-center gap-6"
        asChild={true}
      >
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.connection", "Connection")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card>
              <CardContent>
                <FormProvider
                  id="login-form"
                  initialData={{
                    email: "",
                    password: "",
                    remember: false,
                  }}
                  render={() => (
                    <Form
                      className="grid gap-6"
                      method="post"
                      url={route("login")}
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
                            <div className="flex items-center justify-between gap-3">
                              <FormLabel required={true} />
                              <Link
                                className="text-xs"
                                href={route("password.request")}
                              >
                                {trans(
                                  "passwords.link",
                                  "Forgot your password?",
                                )}
                              </Link>
                            </div>
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
                        name="remember"
                        render={({ value, onChange, ...field }) => (
                          <FormItem className="flex-row">
                            <Checkbox
                              checked={value}
                              onCheckedChange={(checked) => onChange(checked)}
                              {...field}
                            />
                            <FormLabel />
                          </FormItem>
                        )}
                      />
                      <FormSubmit>{trans("ui.log_in", "Log in")}</FormSubmit>
                    </Form>
                  )}
                />
                {status}
              </CardContent>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default Login;
