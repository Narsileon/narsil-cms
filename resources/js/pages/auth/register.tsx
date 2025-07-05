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

function Register() {
  const { trans } = useTranslationsStore();

  return (
    <>
      <Head title={trans("ui.registration", "Registration")} />
      <Container
        className="flex flex-col items-center justify-center gap-6"
        asChild={true}
      >
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.registration", "Registration")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card>
              <CardContent>
                <FormProvider
                  id="register-form"
                  initialData={{
                    email: "",
                    first_name: "",
                    last_name: "",
                    password_confirmation: "",
                    password: "",
                  }}
                  render={() => (
                    <Form
                      className="grid gap-6 md:grid-cols-2"
                      method="post"
                      url={route("register.store")}
                    >
                      <FormField
                        name="email"
                        render={({ onChange, ...field }) => (
                          <FormItem className="col-span-full">
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
                          <FormItem className="col-span-1">
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
                          <FormItem className="col-span-1">
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
                        name="first_name"
                        render={({ onChange, ...field }) => (
                          <FormItem className="col-span-1">
                            <FormLabel required={true} />
                            <Input
                              autoComplete="given-name"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        name="last_name"
                        render={({ onChange, ...field }) => (
                          <FormItem className="col-span-1">
                            <FormLabel required={true} />
                            <Input
                              autoComplete="family-name"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormSubmit className="col-span-full">
                        {trans("ui.register", "Register")}
                      </FormSubmit>
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

export default Register;
