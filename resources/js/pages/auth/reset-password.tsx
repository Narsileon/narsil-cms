import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Heading } from "@/components/ui/heading";
import { Input } from "@/components/ui/input";
import { useRoute } from "ziggy-js";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";

type ResetPasswordProps = {
  token: string;
};

const ResetPassword = ({ token }: ResetPasswordProps) => {
  const route = useRoute();
  const { trans } = useTranslationsStore();

  return (
    <div className="absolute top-1/2 left-1/2 grid -translate-x-1/2 -translate-y-1/2 transform gap-4">
      <Heading className="text-center" level="h1" variant="h4">
        {trans("passwords.resetting")}
      </Heading>
      <Card className="w-[18rem]">
        <CardContent>
          <Form
            className="grid gap-6"
            method="post"
            url={route("password.update")}
            attributes={{ token: token }}
          >
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
            <Button type="submit">{trans("ui.reset")}</Button>
          </Form>
        </CardContent>
      </Card>
    </div>
  );
};

export default ResetPassword;
