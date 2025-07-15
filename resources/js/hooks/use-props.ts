import { isEmpty } from "lodash";
import { usePage } from "@inertiajs/react";
import type { LaravelNavigationItem } from "@/types/global";
import type { Theme } from "@/stores/theme-store";

type AuthProps = {
  email: string;
  first_name: string | undefined | null;
  last_name: string | undefined | null;
  two_factor_confirmed_at: string | null;
};

type ConfigurationProps = {
  color: string;
  radius: number;
  theme: Theme;
};

type RedirectProps = {
  error: string;
  info: string;
  success: string;
  warning: string;
};

type GlobalProps = {
  auth: AuthProps & {
    configuration: ConfigurationProps;
  };
  breadcrumb: {
    href: string;
    label: string;
  }[];
  labels: Record<string, string>;
  locale: string;
  redirect: RedirectProps;
  shared: {
    components: {
      sidebar?: {
        content: LaravelNavigationItem[];
      };
      user_menu: {
        content: LaravelNavigationItem[];
      };
    };
  };
};

export function useAuth() {
  const { auth } = usePage<GlobalProps>().props;

  return isEmpty(auth) ? null : auth;
}

export function useComponents() {
  return usePage<GlobalProps>().props.shared?.components ?? {};
}

export function useLabels() {
  return usePage<GlobalProps>().props.labels ?? {};
}

export function useLocale() {
  const locale = usePage<GlobalProps>().props.locale ?? "en";

  return { locale };
}

export function useRedirect() {
  return usePage<GlobalProps>().props.redirect ?? {};
}
